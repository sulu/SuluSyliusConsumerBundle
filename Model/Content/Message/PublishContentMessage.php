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

class PublishContentMessage
{
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
     * @var bool
     */
    private $mandatory;

    /**
     * @var ContentViewInterface|null
     */
    private $contentView;

    public function __construct(string $resourceKey, string $resourceId, string $locale, bool $mandatory = true)
    {
        $this->resourceKey = $resourceKey;
        $this->resourceId = $resourceId;
        $this->locale = $locale;
        $this->mandatory = $mandatory;
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

    public function getMandatory(): bool
    {
        return $this->mandatory;
    }

    public function hasContentView(): bool
    {
        return null !== $this->contentView;
    }

    public function getContentView(): ContentViewInterface
    {
        if (!$this->contentView) {
            throw new MissingResultException(__METHOD__);
        }

        return $this->contentView;
    }

    public function setContentView(ContentViewInterface $contentView): self
    {
        $this->contentView = $contentView;

        return $this;
    }
}
