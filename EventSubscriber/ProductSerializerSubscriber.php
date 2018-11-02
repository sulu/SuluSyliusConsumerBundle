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

use JMS\Serializer\EventDispatcher\Events;
use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\EventDispatcher\ObjectEvent;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductViewInterface;
use Sulu\Component\Content\Compat\StructureInterface;
use Sulu\Component\Content\Compat\StructureManagerInterface;
use Sulu\Component\Content\ContentTypeManagerInterface;
use Sulu\Component\Serializer\ArraySerializationVisitor;

class ProductSerializerSubscriber implements EventSubscriberInterface
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
        $object = $event->getObject();
        if (!$object instanceof ProductViewInterface) {
            return;
        }

        $contentType = $object->getContent()->getType();
        if (!$contentType) {
            return;
        }

        $structure = $this->structureManager->getStructure($contentType, ProductInterface::RESOURCE_KEY);
        $structure->setLanguageCode($object->getLocale());

        /** @var ArraySerializationVisitor $visitor */
        $visitor = $event->getVisitor();
        $visitor->setData('extension', [/* TODO seo and excerpt */]);
        $visitor->setData('urls', [/* TODO localized urls */]);
        $visitor->setData('product', $object->getProductData());
        $visitor->setData('content', $this->resolveContent($structure, $object->getContent()->getData()));
        $visitor->setData('view', $this->resolveView($structure, $object->getContent()->getData()));
        $visitor->setData('template', $object->getContent()->getType());

        // TODO creator, created, changer, changed
    }

    private function resolveView(StructureInterface $structure, array $data): array
    {
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

    private function resolveContent(StructureInterface $structure, array $data)
    {
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
