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

use Sulu\Bundle\SyliusConsumerBundle\Model\Address\AddressInterface;

class AddressOrderMessage
{
    /**
     * @var int
     */
    private $orderId;

    /**
     * @var AddressInterface
     */
    private $shippingAddress;

    /**
     * @var AddressInterface|null
     */
    private $billingAddress;

    public function __construct(
        int $orderId,
        AddressInterface $shippingAddress,
        ?AddressInterface $billingAddress = null
    ) {
        $this->orderId = $orderId;
        $this->shippingAddress = $shippingAddress;
        $this->billingAddress = $billingAddress;
    }

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function getShippingAddress(): AddressInterface
    {
        return $this->shippingAddress;
    }

    public function getBillingAddress(): ?AddressInterface
    {
        return $this->billingAddress;
    }
}
