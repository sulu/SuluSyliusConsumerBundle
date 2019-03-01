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

use Sulu\Bundle\PersistenceBundle\DependencyInjection\PersistenceExtensionTrait;
use Sulu\Bundle\SyliusConsumerBundle\Model\Category\Category;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;
use Sulu\Bundle\SyliusConsumerBundle\Repository\Category\CategoryRepository;
use Sulu\Component\Content\Compat\Structure\StructureBridge;
use Sulu\Component\HttpKernel\SuluKernel;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class SuluSyliusConsumerExtension extends Extension implements PrependExtensionInterface
{
    use PersistenceExtensionTrait;

    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $this->configurePersistence($config['objects'], $container);

        $container->setParameter('sulu_sylius_consumer.sylius_base_url', $config['sylius_base_url']);
        $container->setParameter('sulu_sylius_consumer.sylius_default_channel', $config['sylius_default_channel']);
        $container->setParameter('sulu_sylius_consumer.sylius_oauth_config', $config['sylius_oauth_config']);
        $container->setParameter('sulu_sylius_consumer.auto_publish', $config['auto_publish']);
        $container->setParameter(
            'sulu_sylius_consumer.route_defaults_fallback',
            $this->getRouteDefaultsFallback($config['route_defaults_fallback'])
        );
        $container->setParameter('sulu_sylius_consumer.firewall_provider_key', $config['firewall_provider_key']);
        $container->setParameter('sulu_sylius_consumer.mail_sender', $config['mail_sender']);
        $container->setParameter('sulu_sylius_consumer.verify.redirect_to', $config['verify']['redirect_to']);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');
    }

    private function getRouteDefaultsFallback(array $config): array
    {
        return [
            'view' => $config['view'],
            '_controller' => $config['controller'],
            '_cacheLifetime' => $config['cache_lifetime'],
        ];
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
                        'type_map' => [
                            ProductInterface::CONTENT_RESOURCE_KEY => StructureBridge::class,
                        ],
                        'paths' => [
                            ProductInterface::CONTENT_RESOURCE_KEY => [
                                'path' => '%kernel.project_dir%/config/templates/products',
                                'type' => ProductInterface::CONTENT_RESOURCE_KEY,
                            ],
                        ],
                        'resources' => [
                            ProductInterface::CONTENT_RESOURCE_KEY => [
                                'types' => [ProductInterface::CONTENT_RESOURCE_KEY],
                                'endpoint' => 'sulu_sylius_product.get_product-contents',
                            ],
                        ],
                    ],
                ],
            ]
        );

        if (!$container->hasExtension('sulu_category')) {
            throw new \RuntimeException('Missing SuluCategoryBundle.');
        }

        $container->prependExtensionConfig(
            'sulu_category',
            [
                'objects' => [
                    'category' => [
                        'model' => Category::class,
                        'repository' => CategoryRepository::class,
                    ],
                ],
            ]
        );

        if (!$container->hasExtension('sulu_media')) {
            throw new \RuntimeException('Missing SuluMediaBundle.');
        }

        $container->prependExtensionConfig(
            'sulu_media',
            [
                'system_collections' => [
                    'sylius' => [
                        'meta_title' => [
                            'en' => 'Sylius Media',
                            'de' => 'Sylius Medien',
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
                'lists' => [
                    'directories' => [
                        __DIR__ . '/../Resources/config/lists',
                    ],
                ],
                'forms' => [
                    'directories' => [
                        __DIR__ . '/../Resources/config/forms',
                    ],
                ],
                'resources' => [
                    ProductInterface::RESOURCE_KEY => [
                        'endpoint' => 'sulu_sylius_product.get_products',
                    ],
                ],
            ]
        );
    }
}
