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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Order\Message;

class CompleteOrderMessage
{
    /**
     * @var int
     */
    private $orderId;

    /**
     * @var string|null
     */
    private $notes;

    public function __construct(int $orderId, ?string $notes = null)
    {
        $this->orderId = $orderId;
        $this->notes = $notes;
    }

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }
}
