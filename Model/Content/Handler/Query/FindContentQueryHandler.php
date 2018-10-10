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

class FindContentQueryHandler
{
    /**
     * @var ContentRepositoryInterface
     */
    private $contentRepository;

    public function __construct(ContentRepositoryInterface $contentRepository)
    {
        $this->contentRepository = $contentRepository;
    }

    public function __invoke(FindContentQuery $query): ContentInterface
    {
        $content = $this->contentRepository->findByResource($query->getResourceKey(), $query->getResourceId());
        if (!$content) {
            throw new ContentNotFoundException($query->getResourceKey(), $query->getResourceId());
        }

        return $content;
    }
}
