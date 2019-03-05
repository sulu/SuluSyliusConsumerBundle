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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Content\Message;

use Sulu\Bundle\SyliusConsumerBundle\Model\Content\ContentViewInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\MissingResultException;
use Sulu\Bundle\SyliusConsumerBundle\Model\PayloadTrait;

class ModifyContentMessage
{
    use PayloadTrait;

    /**
     * @var string
     */
    private $resourceKey;

    /**
     * @var string
     */
    private $resourceId;

    /**
     * @var string
     */
    private $locale;

    /**
     * @var ContentViewInterface|null
     */
    private $content;

    public function __construct(string $resourceKey, string $resourceId, string $locale, array $payload)
    {
        $this->resourceKey = $resourceKey;
        $this->resourceId = $resourceId;
        $this->locale = $locale;

        $this->initializePayload($payload);
    }

    public function getResourceKey(): string
    {
        return $this->resourceKey;
    }

    public function getResourceId(): string
    {
        return $this->resourceId;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function getType(): string
    {
        return $this->getStringValue('type');
    }

    public function getData(): array
    {
        return $this->getArrayValue('data');
    }

    public function getContent(): ContentViewInterface
    {
        if (!$this->content) {
            throw new MissingResultException(__METHOD__);
        }

        return $this->content;
    }

    public function setContent(ContentViewInterface $content): self
    {
        $this->content = $content;

        return $this;
    }
}
