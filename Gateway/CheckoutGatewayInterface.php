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

namespace Sulu\Bundle\SyliusConsumerBundle\Gateway;

use Sulu\Bundle\SyliusConsumerBundle\Model\Address\AddressInterface;

interface CheckoutGatewayInterface
{
    public function addressing(
        int $orderId,
        AddressInterface $shippingAddress,
        ?AddressInterface $billingAddress = null
    ): void;

    public function complete(int $orderId): void;
}
