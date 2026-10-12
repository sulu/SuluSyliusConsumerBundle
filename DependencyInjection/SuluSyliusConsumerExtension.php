<?php

declare(strict_types=1);

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\SyliusConsumerBundle\DependencyInjection;

use Sulu\Bundle\PersistenceBundle\DependencyInjection\PersistenceExtensionTrait;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class SuluSyliusConsumerExtension extends Extension
{
    use PersistenceExtensionTrait;

    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $this->configurePersistence($config['objects'], $container);

        $container->setParameter('sulu_sylius_consumer.sylius_base_url', $config['sylius_base_url']);
        $container->setParameter('sulu_sylius_consumer.auto_publish', $config['auto_publish']);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('handler.xml');

        if ($config['image_media_adapter']['enabled'] ?? false) {
            $loader->load('image_media_adapter.xml');
            $collectionKey = $config['image_media_adapter']['media_collection_key'];
            $container->setParameter('sulu_sylius_consumer.media_collection.key', $collectionKey);
        }

        if ($config['product_adapter']['enabled'] ?? false) {
            $loader->load('product_adapter.xml');
            $container->setParameter('sulu_sylius_consumer.product_adapter.locales', $config['product_adapter']['locales']);
            $container->setParameter('sulu_sylius_consumer.product_adapter.family_key', $config['product_adapter']['family_key']);
            $container->setParameter('sulu_sylius_consumer.product_adapter.template', $config['product_adapter']['template']);
            $container->setParameter('sulu_sylius_consumer.product_adapter.url_prefix', $config['product_adapter']['url_prefix']);
        }

        if ($config['taxon_category_adapter']['enabled'] ?? false) {
            $loader->load('taxon_category_adapter.xml');
        }
    }
}
