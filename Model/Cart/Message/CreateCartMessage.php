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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Cart\Message;

use Sulu\Bundle\SyliusConsumerBundle\Security\SyliusUserInterface;

class CreateCartMessage
{
    /**
     * @var SyliusUserInterface
     */
    private $syliusUser;

    /**
     * @var string
     */
    private $locale;

    /**
     * @var null|string
     */
    private $channel;

    public function __construct(
        SyliusUserInterface $syliusUser,
        string $locale,
        string $channel
    ) {
        $this->syliusUser = $syliusUser;
        $this->locale = $locale;
        $this->channel = $channel;
    }

    public function getSyliusUser(): ?SyliusUserInterface
    {
        return $this->syliusUser;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function getChannel(): ?string
    {
        return $this->channel;
    }
}
