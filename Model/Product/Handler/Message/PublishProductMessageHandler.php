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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Product\Handler\Message;

use Sulu\Bundle\SyliusConsumerBundle\Model\Content\Message\PublishContentMessage;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\PublishProductMessage;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\RoutableResource\Message\PublishRoutableResourceMessage;
use Symfony\Cmf\Api\Slugifier\SlugifierInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class PublishProductMessageHandler
{
    /**
     * @var MessageBusInterface
     */
    private $messageBus;

    /**
     * @var SlugifierInterface
     */
    private $slugifier;

    public function __construct(MessageBusInterface $messageBus, SlugifierInterface $slugifier)
    {
        $this->messageBus = $messageBus;
        $this->slugifier = $slugifier;
    }

    public function __invoke(PublishProductMessage $message): void
    {
        $this->messageBus->dispatch(
            new PublishContentMessage(ProductInterface::RESOURCE_KEY, $message->getCode(), $message->getLocale())
        );

        // FIXME generate route by-schema
        $routePath = '/products/' . $this->slugifier->slugify($message->getCode());
        $this->messageBus->dispatch(
            new PublishRoutableResourceMessage(
                ProductInterface::RESOURCE_KEY,
                $message->getCode(),
                $message->getLocale(),
                $routePath
            )
        );
    }
}
