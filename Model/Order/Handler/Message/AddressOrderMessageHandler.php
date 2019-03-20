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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Order\Handler\Message;

use Sulu\Bundle\SyliusConsumerBundle\Gateway\CheckoutGatewayInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Order\Message\AddressOrderMessage;

class AddressOrderMessageHandler
{
    /**
     * @var CheckoutGatewayInterface
     */
    private $checkoutGateway;

    public function __construct(CheckoutGatewayInterface $checkoutGateway)
    {
        $this->checkoutGateway = $checkoutGateway;
    }

    public function __invoke(AddressOrderMessage $message): void
    {
        $this->checkoutGateway->addressing(
            $message->getOrderId(),
            $message->getShippingAddress(),
            $message->getBillingAddress()
        );
    }
}
