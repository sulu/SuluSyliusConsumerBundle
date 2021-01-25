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

use Sulu\Bundle\SyliusConsumerBundle\Entity\TaxonCategoryReference;
use Sulu\Bundle\SyliusConsumerBundle\Repository\TaxonCategoryReferenceRepository;
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
                ->arrayNode('default_taxon_adapter')->canBeEnabled()->end()
                ->arrayNode('objects')
                        ->addDefaultsIfNotSet()
                        ->children()
                            ->arrayNode('taxon_category_reference')
                                ->addDefaultsIfNotSet()
                                ->children()
                                    ->scalarNode('model')->defaultValue(TaxonCategoryReference::class)->end()
                                    ->scalarNode('repository')->defaultValue(TaxonCategoryReferenceRepository::class)->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
