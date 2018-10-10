<?php

declare(strict_types=1);

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\SyliusConsumerBundle\DependencyInjection;

use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Product;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;
use Sulu\Component\HttpKernel\SuluKernel;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class SuluSyliusConsumerExtension extends Extension implements PrependExtensionInterface
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

        $loader->load('services.xml');
    }

    public function prepend(ContainerBuilder $container)
    {
        if (!$container->hasExtension('doctrine')) {
            throw new \RuntimeException('Missing DoctrineBundle.');
        }

        $container->prependExtensionConfig(
            'doctrine',
            [
                'orm' => [
                    'entity_managers' => [
                        'default' => [
                            'mappings' => [
                                'SuluSyliusConsumerBundle' => [
                                    'type' => 'xml',
                                    'prefix' => 'Sulu\\Bundle\\SyliusConsumerBundle\\Model',
                                    'dir' => 'Resources/config/doctrine',
                                    'alias' => 'SuluSyliusConsumerBundle',
                                    'is_bundle' => true,
                                    'mapping' => true,
                                ],
                            ],
                        ],
                    ],
                ],
            ]
        );

        if (!$container->hasExtension('jms_serializer')) {
            throw new \RuntimeException('Missing JmsSerializerBundle.');
        }

        $container->prependExtensionConfig(
            'jms_serializer',
            [
                'metadata' => [
                    'directories' => [
                        [
                            'name' => 'SuluSyliusConsumerBundle',
                            'path' => __DIR__ . '/../Resources/config/serializer',
                            'namespace_prefix' => 'Sulu\\Bundle\\SyliusConsumerBundle\\Model',
                        ],
                    ],
                ],
            ]
        );

        if (!$container->hasExtension('sulu_core')) {
            throw new \RuntimeException('Missing SuluCoreBundle.');
        }

        $container->prependExtensionConfig(
            'sulu_core',
            [
                'content' => [
                    'structure' => [
                        'paths' => [
                            ProductInterface::RESOURCE_KEY => [
                                'path' => '%kernel.project_dir%/config/templates/products',
                                'type' => ProductInterface::RESOURCE_KEY,
                            ],
                        ],
                        'resources' => [
                            'product_contents' => [
                                'datagrid' => Product::class,
                                'types' => [ProductInterface::RESOURCE_KEY],
                                'endpoint' => 'sulu_sylius_product.get_product-contents',
                            ],
                        ],
                    ],
                ],
            ]
        );

        $this->prependForAdmin($container);
    }

    public function prependForAdmin(ContainerBuilder $container)
    {
        if (SuluKernel::CONTEXT_ADMIN !== $container->getParameter('sulu.context')) {
            return;
        }

        if (!$container->hasExtension('sulu_admin')) {
            throw new \RuntimeException('Missing SuluAdminBundle.');
        }

        $container->prependExtensionConfig(
            'sulu_admin',
            [
                'resources' => [
                    ProductInterface::RESOURCE_KEY => [
                        'datagrid' => Product::class,
                        'form' => ['@SuluSyliusConsumerBundle/Resources/config/forms/Product.Product.xml'],
                        'endpoint' => 'sulu_sylius_product.get_products',
                    ],
                ],
            ]
        );
    }
}
