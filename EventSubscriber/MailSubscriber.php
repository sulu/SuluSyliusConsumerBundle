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
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MailSubscriber implements EventSubscriberInterface
{
    /**
     * @var MailFactory
     */
    protected $mailFactory;

    public function __construct(MailFactory $mailFactory)
    {
        $this->mailFactory = $mailFactory;
    }

    public static function getSubscribedEvents()
    {
        return [
            CustomerCreatedEvent::NAME => 'handleCustomerCreated',
        ];
    }

    public function handleCustomerCreated(CustomerCreatedEvent $event): void
    {
        $this->mailFactory->sendVerifyEmail($event->getCustomer());
    }
}
