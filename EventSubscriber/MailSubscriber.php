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

namespace Sulu\Bundle\SyliusConsumerBundle\EventSubscriber;

use Sulu\Bundle\SyliusConsumerBundle\Mail\MailFactory;
use Sulu\Bundle\SyliusConsumerBundle\Model\Customer\Event\CustomerCreatedEvent;
use Sulu\Bundle\SyliusConsumerBundle\Model\Order\Event\OrderCompletedEvent;
use Sulu\Bundle\SyliusConsumerBundle\Model\Order\Query\FindOrderQuery;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class MailSubscriber implements EventSubscriberInterface
{
    /**
     * @var MessageBusInterface
     */
    protected $messageBus;

    /**
     * @var MailFactory
     */
    protected $mailFactory;

    public function __construct(MessageBusInterface $messageBus, MailFactory $mailFactory)
    {
        $this->messageBus = $messageBus;
        $this->mailFactory = $mailFactory;
    }

    public static function getSubscribedEvents()
    {
        return [
            CustomerCreatedEvent::NAME => 'handleCustomerCreated',
            OrderCompletedEvent::NAME => 'handleOrderCompleted',
        ];
    }

    public function handleCustomerCreated(CustomerCreatedEvent $event): void
    {
        $this->mailFactory->sendVerifyEmail($event->getCustomer());
    }

    public function handleOrderCompleted(OrderCompletedEvent $event): void
    {
        $findOrderMessage = new FindOrderQuery($event->getId());
        $this->messageBus->dispatch($findOrderMessage);

        $this->mailFactory->sendOrderConfirmationEmail(
            $findOrderMessage->getCustomer(),
            $findOrderMessage->getOrder()
        );
    }
}
