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

use Sulu\Bundle\SyliusConsumerBundle\Model\Content\ContentViewInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\Query\FindContentQuery;
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\View\ContentViewFactoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionInterface;

class FindContentQueryHandler
{
    /**
     * @var ContentViewFactoryInterface
     */
    private $contentViewFactory;

    public function __construct(
        ContentViewFactoryInterface $contentViewFactory
    ) {
        $this->contentViewFactory = $contentViewFactory;
    }

    public function __invoke(FindContentQuery $query): ContentViewInterface
    {
        $content = $this->contentViewFactory->create(
            $query->getResourceKey(),
            $query->getResourceId(),
            DimensionInterface::ATTRIBUTE_VALUE_DRAFT, $query->getLocale()
        );

        return $content;
    }
}
