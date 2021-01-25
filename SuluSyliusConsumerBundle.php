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
use Sulu\Bundle\SyliusConsumerBundle\Adapter\TaxonAdapterInterface;
use Sulu\Bundle\SyliusConsumerBundle\Entity\TaxonCategoryReferenceInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SuluSyliusConsumerBundle extends Bundle
{
    use PersistenceBundleTrait;

    public function build(ContainerBuilder $container)
    {
        $container->registerForAutoconfiguration(TaxonAdapterInterface::class)
            ->addTag('sulu_sylius_consumer.adapter.taxon');

        $this->buildPersistence(
            [
                TaxonCategoryReferenceInterface::class => 'sulu.model.taxon_category_reference.class',
            ],
            $container
        );
    }
}
