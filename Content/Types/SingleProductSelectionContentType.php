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

namespace Sulu\Bundle\SyliusConsumerBundle\Content\Types;

use Sulu\Bundle\SyliusConsumerBundle\Content\ProxyFactory;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Exception\ProductInformationNotFoundException;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Query\FindProductViewQuery;
use Sulu\Bundle\WebsiteBundle\ReferenceStore\ReferenceStoreInterface;
use Sulu\Component\Content\Compat\PropertyInterface;
use Sulu\Component\Content\SimpleContentType;
use Symfony\Component\Messenger\MessageBusInterface;

class SingleProductSelectionContentType extends SimpleContentType
{
    /**
     * @var MessageBusInterface
     */
    private $messageBus;

    /**
     * @var ReferenceStoreInterface
     */
    private $productReferenceStore;

    /**
     * @var ProxyFactory
     */
    private $proxyFactory;

    public function __construct(
        MessageBusInterface $messageBus,
        ReferenceStoreInterface $productReferenceStore,
        ProxyFactory $proxyFactory
    ) {
        parent::__construct('SingleProductSelection');

        $this->messageBus = $messageBus;
        $this->productReferenceStore = $productReferenceStore;
        $this->proxyFactory = $proxyFactory;
    }

    /**
     * @return array|null
     */
    public function getContentData(PropertyInterface $property)
    {
        $id = $property->getValue();
        if (!$id) {
            return null;
        }

        return $this->findProduct($id, $property->getStructure()->getLanguageCode());
    }

    private function findProduct(string $id, string $locale)
    {
        try {
            $query = new FindProductViewQuery($id, $locale);
            $this->messageBus->dispatch($query);

            $productView = $query->getProductView();

            return $this->proxyFactory->createProxy($productView);
        } catch (ProductInformationNotFoundException $exception) {
            return null;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function preResolve(PropertyInterface $property)
    {
        $id = $property->getValue();
        if (!$id) {
            return;
        }

        $this->productReferenceStore->add($id);
    }
}
