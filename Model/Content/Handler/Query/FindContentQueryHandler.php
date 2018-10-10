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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Content\Handler\Query;

use Sulu\Bundle\SyliusConsumerBundle\Model\Content\ContentInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\ContentRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\Exception\ContentNotFoundException;
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\Query\FindContentQuery;
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\View\ContentViewFactoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionRepositoryInterface;

class FindContentQueryHandler
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
     * @var ContentViewFactoryInterface
     */
    private $contentViewFactory;

    public function __construct(
        ContentRepositoryInterface $contentRepository,
        DimensionRepositoryInterface $dimensionRepository,
        ContentViewFactoryInterface $contentViewFactory
    ) {
        $this->contentRepository = $contentRepository;
        $this->dimensionRepository = $dimensionRepository;
        $this->contentViewFactory = $contentViewFactory;
    }

    public function __invoke(FindContentQuery $query): ContentInterface
    {
        $dimensions = [
            $this->dimensionRepository->findOrCreateByAttributes(
                [DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_DRAFT]
            ),
            $this->dimensionRepository->findOrCreateByAttributes(
                [
                    DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_DRAFT,
                    DimensionInterface::ATTRIBUTE_KEY_LOCALE => $query->getLocale(),
                ]
            ),
        ];

        $contents = $this->contentRepository->findByDimensions(
            $query->getResourceKey(),
            $query->getResourceId(),
            $dimensions
        );

        $content = $this->contentViewFactory->create($contents);
        if (!$content) {
            throw new ContentNotFoundException($query->getResourceKey(), $query->getResourceId());
        }

        return $content;
    }
}
