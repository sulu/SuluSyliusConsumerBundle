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
    }
}
