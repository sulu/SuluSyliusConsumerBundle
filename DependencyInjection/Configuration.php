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
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInformation;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductVariant;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductVariantInformation;
use Sulu\Bundle\SyliusConsumerBundle\Repository\Product\ProductInformationRepository;
use Sulu\Bundle\SyliusConsumerBundle\Repository\Product\ProductRepository;
use Sulu\Bundle\SyliusConsumerBundle\Repository\Product\ProductVariantInformationRepository;
use Sulu\Bundle\SyliusConsumerBundle\Repository\Product\ProductVariantRepository;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $treeBuilder->root('sulu_sylius_consumer')
            ->children()
                ->scalarNode('sylius_base_url')->isRequired()->end()
                ->booleanNode('auto_publish')->defaultFalse()->end()
                ->arrayNode('route_defaults_fallback')
                    ->addDefaultsIfNotSet()
                    ->isRequired()
                    ->children()
                        ->scalarNode('view')->isRequired()->end()
                        ->scalarNode('controller')->defaultValue('SuluSyliusConsumerBundle:Product/WebsiteProduct:index')->end()
                        ->scalarNode('cache_lifetime')->defaultValue(604800)->end()
                    ->end()
                ->end()
                ->arrayNode('objects')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('product')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('model')->defaultValue(Product::class)->end()
                                ->scalarNode('repository')->defaultValue(ProductRepository::class)->end()
                            ->end()
                        ->end()
                        ->arrayNode('product_information')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('model')->defaultValue(ProductInformation::class)->end()
                                ->scalarNode('repository')->defaultValue(ProductInformationRepository::class)->end()
                            ->end()
                        ->end()
                        ->arrayNode('product_variant')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('model')->defaultValue(ProductVariant::class)->end()
                                ->scalarNode('repository')->defaultValue(ProductVariantRepository::class)->end()
                            ->end()
                        ->end()
                        ->arrayNode('product_variant_information')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('model')->defaultValue(ProductVariantInformation::class)->end()
                                ->scalarNode('repository')->defaultValue(ProductVariantInformationRepository::class)->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
