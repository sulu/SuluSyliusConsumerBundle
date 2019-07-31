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

use JMS\Serializer\SerializerInterface;
use Sulu\Bundle\SyliusConsumerBundle\Content\ContentProxyFactory;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Exception\ProductInformationNotFoundException;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Query\FindProductViewQuery;
use Sulu\Bundle\WebsiteBundle\ReferenceStore\ReferenceStoreInterface;
use Sulu\Component\Content\Compat\PropertyInterface;
use Sulu\Component\Content\SimpleContentType;
use Symfony\Component\Messenger\MessageBusInterface;

class SingleProductSelectionContentType extends SimpleContentType
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var MessageBusInterface
     */
    private $messageBus;

    /**
     * @var ReferenceStoreInterface
     */
    private $productReferenceStore;

    /**
     * @var ContentProxyFactory
     */
    private $contentProxyFactory;

    public function __construct(
        MessageBusInterface $messageBus,
        SerializerInterface $serializer,
        ReferenceStoreInterface $productReferenceStore,
        ContentProxyFactory $contentProxyFactory
    ) {
        parent::__construct('SingleProductSelection');

        $this->messageBus = $messageBus;
        $this->serializer = $serializer;
        $this->productReferenceStore = $productReferenceStore;
        $this->contentProxyFactory = $contentProxyFactory;
    }

    /**
     * @param PropertyInterface $property
     *
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

            return $this->contentProxyFactory->createContentProxy($this->serializer, $productView);
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
