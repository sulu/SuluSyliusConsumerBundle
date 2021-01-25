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

use Sulu\Bundle\SyliusConsumerBundle\Entity\TaxonCategoryBridge;
use Sulu\Bundle\SyliusConsumerBundle\Repository\TaxonCategoryBridgeRepository;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('sulu_sylius_consumer');
        $treeBuilder->getRootNode()
            ->children()
                ->scalarNode('sylius_base_url')->isRequired()->end()
                ->booleanNode('auto_publish')->defaultFalse()->end()
                ->arrayNode('taxon_category_adapter')->canBeEnabled()->end()
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
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
