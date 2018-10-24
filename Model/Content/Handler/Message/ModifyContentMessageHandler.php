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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Content\Handler\Message;

use Sulu\Bundle\SyliusConsumerBundle\Model\Content\ContentInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\ContentRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\ContentViewInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\Exception\ContentNotFoundException;
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\Message\ModifyContentMessage;
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\View\ContentViewFactoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionRepositoryInterface;
use Sulu\Component\Content\Metadata\Factory\StructureMetadataFactoryInterface;

class ModifyContentMessageHandler
{
    /**
     * @var ContentRepositoryInterface
     */
    private $contentRepository;

    /**
     * @var DimensionRepositoryInterface
     */
    private $dimensionRepository;

    /**
     * @var StructureMetadataFactoryInterface
     */
    private $factory;

    /**
     * @var ContentViewFactoryInterface
     */
    private $contentViewFactory;

    public function __construct(
        ContentRepositoryInterface $contentRepository,
        DimensionRepositoryInterface $dimensionRepository,
        StructureMetadataFactoryInterface $factory,
        ContentViewFactoryInterface $contentViewFactory
    ) {
        $this->contentRepository = $contentRepository;
        $this->dimensionRepository = $dimensionRepository;
        $this->factory = $factory;
        $this->contentViewFactory = $contentViewFactory;
    }

    public function __invoke(ModifyContentMessage $message): ContentViewInterface
    {
        $draftDimension = $this->dimensionRepository->findOrCreateByAttributes(
            [DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_DRAFT]
        );
        $localizedDraftDimension = $this->dimensionRepository->findOrCreateByAttributes(
            [
                DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_DRAFT,
                DimensionInterface::ATTRIBUTE_KEY_LOCALE => $message->getLocale(),
            ]
        );

        $localizedDraftContent = $this->contentRepository->findOrCreate(
            $message->getResourceKey(),
            $message->getResourceId(),
            $localizedDraftDimension
        );

        $draftContent = $this->contentRepository->findOrCreate(
            $message->getResourceKey(),
            $message->getResourceId(),
            $draftDimension
        );

        $draftContent->setType($message->getType());
        $localizedDraftContent->setType($message->getType());

        $this->setData($message, $draftContent, $localizedDraftContent);

        $contentView = $this->contentViewFactory->create([$localizedDraftContent, $draftContent]);
        if (!$contentView) {
            throw new ContentNotFoundException($message->getResourceKey(), $message->getResourceId());
        }

        return $contentView;
    }

    private function setData(
        ModifyContentMessage $message,
        ContentInterface $draftContent,
        ContentInterface $localizedDraftContent
    ): void {
        $data = $message->getData();
        $metadata = $this->factory->getStructureMetadata($message->getResourceKey(), $message->getType());
        if (!$metadata) {
            return;
        }

        $localizedDraftData = [];
        $draftData = [];
        foreach ($metadata->getProperties() as $property) {
            $value = null;
            if (array_key_exists($property->getName(), $data)) {
                $value = $data[$property->getName()];
            }

            if ($property->isLocalized()) {
                $localizedDraftData[$property->getName()] = $value;

                continue;
            }

            $draftData[$property->getName()] = $value;
        }

        $localizedDraftContent->setData($localizedDraftData);
        $draftContent->setData($draftData);
    }
}
