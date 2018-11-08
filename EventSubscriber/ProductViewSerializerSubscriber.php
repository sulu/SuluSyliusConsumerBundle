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

namespace Sulu\Bundle\SyliusConsumerBundle\EventSubscriber;

use JMS\Serializer\Context;
use JMS\Serializer\EventDispatcher\Events;
use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\EventDispatcher\ObjectEvent;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductViewInterface;
use Sulu\Component\Content\Compat\StructureInterface;
use Sulu\Component\Content\Compat\StructureManagerInterface;
use Sulu\Component\Content\ContentTypeManagerInterface;
use Sulu\Component\Serializer\ArraySerializationVisitor;

class ProductViewSerializerSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            [
                'event' => Events::POST_SERIALIZE,
                'format' => 'array',
                'method' => 'onPostSerialize',
            ],
        ];
    }

    /**
     * @var StructureManagerInterface
     */
    private $structureManager;

    /**
     * @var ContentTypeManagerInterface
     */
    private $contentTypeManager;

    public function __construct(
        StructureManagerInterface $structureManager,
        ContentTypeManagerInterface $contentTypeManager
    ) {
        $this->structureManager = $structureManager;
        $this->contentTypeManager = $contentTypeManager;
    }

    public function onPostSerialize(ObjectEvent $event): void
    {
        $productView = $event->getObject();
        if (!$productView instanceof ProductViewInterface) {
            return;
        }

        $structure = $this->getStructure($productView);
        $data = $productView->getContent() ? $productView->getContent()->getData() : [];

        /** @var ArraySerializationVisitor $visitor */
        $visitor = $event->getVisitor();
        $visitor->setData('product', $this->getProductData($productView, $event->getContext()));
        $visitor->setData('extension', [/* TODO seo and excerpt */]);
        $visitor->setData('urls', [/* TODO localized urls */]);
        $visitor->setData('content', $this->resolveContent($structure, $data));
        $visitor->setData('view', $this->resolveView($structure, $data));
        $visitor->setData('template', $structure ? $structure->getKey() : null);

        // TODO creator, created, changer, changed
    }

    private function getStructure(ProductViewInterface $productView): ?StructureInterface
    {
        if (!$productView->getContent()) {
            return null;
        }

        $contentType = $productView->getContent()->getType();
        if (!$contentType) {
            return null;
        }

        $structure = $this->structureManager->getStructure($contentType, ProductInterface::RESOURCE_KEY);
        $structure->setLanguageCode($productView->getLocale());
    }

    protected function getProductData(ProductViewInterface $productView, Context $context): array
    {
        $productData = $context->accept($productView->getProduct());
        $productInformationData = $context->accept($productView->getProductInformation());

        $data = array_merge(
            $context->accept($productView->getProduct()),
            $context->accept($productView->getProductInformation())
        );

        $data['mainCategory'] = $productView->getMainCategory();
        $data['categories'] = $productView->getCategories();
        $data['media'] = $productView->getMedia();

        if (!array_key_exists('customData', $productData)) {
            $productData['customData'] = [];
        }
        if (!array_key_exists('customData', $productInformationData)) {
            $productInformationData['customData'] = [];
        }
        $data['customData'] = array_merge_recursive($productData['customData'], $productInformationData['customData']);

        return $data;
    }

    private function resolveView(?StructureInterface $structure, array $data): array
    {
        if (!$structure) {
            return [];
        }

        $view = [];
        foreach ($structure->getProperties(true) as $child) {
            if (array_key_exists($child->getName(), $data)) {
                $child->setValue($data[$child->getName()]);
            }

            $contentType = $this->contentTypeManager->get($child->getContentTypeName());
            $view[$child->getName()] = $contentType->getViewData($child);
        }

        return $view;
    }

    private function resolveContent(?StructureInterface $structure, array $data)
    {
        if (!$structure) {
            return [];
        }

        $content = [];
        foreach ($structure->getProperties(true) as $child) {
            if (array_key_exists($child->getName(), $data)) {
                $child->setValue($data[$child->getName()]);
            }

            $contentType = $this->contentTypeManager->get($child->getContentTypeName());
            $content[$child->getName()] = $contentType->getContentData($child);
        }

        return $content;
    }
}
