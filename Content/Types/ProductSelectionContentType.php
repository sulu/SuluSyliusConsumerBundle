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
use ProxyManager\Factory\LazyLoadingValueHolderFactory;
use Sulu\Bundle\SyliusConsumerBundle\Content\ContentProxyFactory;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Query\FindProductViewsQuery;
use Sulu\Bundle\WebsiteBundle\ReferenceStore\ReferenceStoreInterface;
use Sulu\Component\Content\Compat\PropertyInterface;
use Sulu\Component\Content\SimpleContentType;
use Symfony\Component\Messenger\MessageBusInterface;

class ProductSelectionContentType extends SimpleContentType
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
        parent::__construct('ProductSelection');

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
        $ids = $property->getValue();
        if (!$ids) {
            return null;
        }

        return $this->findProducts($ids, $property->getStructure()->getLanguageCode());
    }

    private function findProducts(array $ids, string $locale)
    {
        $query = new FindProductViewsQuery($ids, $locale);
        $this->messageBus->dispatch($query);

        $productViews = $query->getProductViews();

        return $this->contentProxyFactory->createContentProxy($this->serializer, $productViews);
    }

    /**
     * {@inheritdoc}
     */
    public function preResolve(PropertyInterface $property)
    {
        $ids = $property->getValue();
        if (!$ids) {
            return;
        }

        foreach ($ids as $id) {
            $this->productReferenceStore->add($id);
        }
    }
}
