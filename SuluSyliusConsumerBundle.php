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

namespace Sulu\Bundle\SyliusConsumerBundle;

use Sulu\Bundle\PersistenceBundle\PersistenceBundleTrait;
use Sulu\Bundle\SyliusConsumerBundle\Adapter\ProductAdapterInterface;
use Sulu\Bundle\SyliusConsumerBundle\Adapter\ProductVariantAdapterInterface;
use Sulu\Bundle\SyliusConsumerBundle\Adapter\TaxonAdapterInterface;
use Sulu\Bundle\SyliusConsumerBundle\Entity\TaxonCategoryBridgeInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SuluSyliusConsumerBundle extends Bundle
{
    use PersistenceBundleTrait;

    public function build(ContainerBuilder $container)
    {
        $container->registerForAutoconfiguration(TaxonAdapterInterface::class)
            ->addTag('sulu_sylius_consumer.adapter.taxon');

        $container->registerForAutoconfiguration(ProductAdapterInterface::class)
            ->addTag('sulu_sylius_consumer.adapter.product');

        $container->registerForAutoconfiguration(ProductVariantAdapterInterface::class)
            ->addTag('sulu_sylius_consumer.adapter.product_variant');

        $this->buildPersistence(
            [
                TaxonCategoryBridgeInterface::class => 'sulu.model.taxon_category_bridge.class',
            ],
            $container
        );
    }
}
