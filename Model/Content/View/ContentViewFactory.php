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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Content\View;

use Sulu\Bundle\SyliusConsumerBundle\Model\Content\ContentInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\ContentRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\ContentView;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionRepositoryInterface;

class ContentViewFactory implements ContentViewFactoryInterface
{
    /**
     * @var DimensionRepositoryInterface
     */
    private $dimensionRepository;

    /**
     * @var ContentRepositoryInterface
     */
    private $contentRepository;

    public function __construct(
        DimensionRepositoryInterface $dimensionRepository,
        ContentRepositoryInterface $contentRepository
    ) {
        $this->dimensionRepository = $dimensionRepository;
        $this->contentRepository = $contentRepository;
    }

    /**
     * @param ContentInterface[] $dimensions
     */
    public function create(string $resourceKey, string $resourceId, string $stage, string $locale): ContentView
    {
        $dimension = $this->dimensionRepository->findOrCreateByAttributes(
            [DimensionInterface::ATTRIBUTE_KEY_STAGE => $stage]
        );
        $localizedDimension = $this->dimensionRepository->findOrCreateByAttributes(
            [
                DimensionInterface::ATTRIBUTE_KEY_STAGE => $stage,
                DimensionInterface::ATTRIBUTE_KEY_LOCALE => $locale,
            ]
        );

        $content = $this->contentRepository->findByResource($resourceKey, $resourceId, $dimension);
        $localizedContent = $this->contentRepository->findByResource($resourceKey, $resourceId, $localizedDimension);

        return new ContentView(
            $resourceKey,
            $resourceId,
            $content->getType(),
            array_merge($content->getData(), $localizedContent->getData())
        );
    }
}
