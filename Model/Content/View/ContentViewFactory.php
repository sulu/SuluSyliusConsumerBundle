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

    public function create(array $contentDimensions): ?ContentView
    {
        $firstDimension = reset($contentDimensions);
        if (!$firstDimension) {
            return null;
        }
        $data = [];
        foreach ($contentDimensions as $contentDimension) {
            $data = array_merge($data, $contentDimension->getData());
        }

        return new ContentView(
            $firstDimension->getResourceKey(),
            $firstDimension->getResourceId(),
            $firstDimension->getType(),
            $data
        );
    }

    /**
     * @param DimensionInterface[] $dimensions
     */
    public function loadAndCreate(string $resourceKey, string $resourceId, array $dimensions): ?ContentView
    {
        /** @var ContentInterface[] $contentDimensions */
        $contentDimensions = $this->contentRepository->findByDimensions($resourceKey, $resourceId, $dimensions);

        return $this->create($contentDimensions);
    }
}
