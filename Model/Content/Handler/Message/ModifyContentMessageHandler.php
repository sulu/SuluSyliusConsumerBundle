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
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\Message\ModifyContentMessage;

class ModifyContentMessageHandler
{
    /**
     * @var ContentRepositoryInterface
     */
    private $contentRepository;

    public function __construct(ContentRepositoryInterface $contentRepository)
    {
        $this->contentRepository = $contentRepository;
    }

    public function __invoke(ModifyContentMessage $message): ContentInterface
    {
        $content = $this->contentRepository->findOrCreate($message->getResourceKey(), $message->getResourceId());

        $content->setType($message->getType());
        $content->setData($message->getData());

        return $content;
    }
}
