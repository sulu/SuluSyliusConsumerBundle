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
                ->scalarNode('sylius_default_channel')->isRequired()->end()
                ->scalarNode('sylius_api_default_limit')->defaultValue(10)->end()
                ->arrayNode('sylius_oauth_config')
                    ->isRequired()
                    ->children()
                        ->scalarNode('username')->isRequired()->end()
                        ->scalarNode('password')->isRequired()->end()
                        ->scalarNode('client_id')->isRequired()->end()
                        ->scalarNode('client_secret')->isRequired()->end()
                        ->scalarNode('token_url')->defaultValue('/api/oauth/v2/token')->end()
                    ->end()
                ->end()
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
                ->scalarNode('firewall_provider_key')->isRequired()->end()
                ->arrayNode('mail_sender')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('name')->defaultValue('Example.com')->end()
                        ->scalarNode('address')->defaultValue('no-reply@example.com')->end()
                    ->end()
                ->end()
                ->arrayNode('verify')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('redirect_to')->defaultValue('/')->end()
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
