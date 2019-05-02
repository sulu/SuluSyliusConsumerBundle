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
use Sulu\Bundle\SyliusConsumerBundle\Middleware\EventCollector;
use Sulu\Bundle\SyliusConsumerBundle\Model\Order\Event\OrderCompletedEvent;
use Sulu\Bundle\SyliusConsumerBundle\Model\Order\Message\CompleteOrderMessage;

class CompleteOrderMessageHandler
{
    /**
     * @var CheckoutGatewayInterface
     */
    private $checkoutGateway;

    /**
     * @var EventCollector
     */
    private $eventCollector;

    public function __construct(CheckoutGatewayInterface $checkoutGateway, EventCollector $eventCollector)
    {
        $this->checkoutGateway = $checkoutGateway;
        $this->eventCollector = $eventCollector;
    }

    public function __invoke(CompleteOrderMessage $message): void
    {
        $this->checkoutGateway->complete($message->getOrderId(), $message->getNotes());

        $event = new OrderCompletedEvent($message->getOrderId());
        $this->eventCollector->push($event::NAME, $event);
    }
}
