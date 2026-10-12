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

use Sulu\Bundle\SyliusConsumerBundle\Entity\ImageMediaBridge;
use Sulu\Bundle\SyliusConsumerBundle\Entity\TaxonCategoryBridge;
use Sulu\Bundle\SyliusConsumerBundle\Repository\ImageMediaBridgeRepository;
use Sulu\Bundle\SyliusConsumerBundle\Repository\TaxonCategoryBridgeRepository;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('sulu_sylius_consumer');
        $treeBuilder->getRootNode()
            ->children()
                ->scalarNode('sylius_base_url')->isRequired()->end()
                ->booleanNode('auto_publish')->defaultFalse()->end()
                ->arrayNode('taxon_category_adapter')->canBeEnabled()->end()
                ->arrayNode('product_adapter')
                    ->info('Writes products and variants into sulu/product-bundle')
                    ->canBeEnabled()
                    ->children()
                        ->arrayNode('locales')
                            ->info('Sulu languages to synchronize, the first one is the default')
                            ->scalarPrototype()->end()
                            ->defaultValue(['en'])
                        ->end()
                        ->scalarNode('family_key')->defaultValue('sylius')->end()
                        ->scalarNode('template')->defaultValue('product')->end()
                        ->scalarNode('url_prefix')->defaultValue('/products/')->end()
                    ->end()
                ->end()
                ->arrayNode('image_media_adapter')
                    ->canBeEnabled()
                    ->children()
                        ->scalarNode('media_collection_key')->defaultValue('product_images')->end()
                    ->end()
                ->end()
                ->arrayNode('objects')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('taxon_category_bridge')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('model')->defaultValue(TaxonCategoryBridge::class)->end()
                                ->scalarNode('repository')->defaultValue(TaxonCategoryBridgeRepository::class)->end()
                            ->end()
                        ->end()
                        ->arrayNode('image_media_bridge')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('model')->defaultValue(ImageMediaBridge::class)->end()
                                ->scalarNode('repository')->defaultValue(ImageMediaBridgeRepository::class)->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
