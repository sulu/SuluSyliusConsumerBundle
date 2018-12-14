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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Customer\Handler\Message;

use Sulu\Bundle\SyliusConsumerBundle\Gateway\CustomerGatewayInterface;
use Sulu\Bundle\SyliusConsumerBundle\Middleware\EventCollector;
use Sulu\Bundle\SyliusConsumerBundle\Model\Customer\Customer;
use Sulu\Bundle\SyliusConsumerBundle\Model\Customer\Event\CustomerCreatedEvent;
use Sulu\Bundle\SyliusConsumerBundle\Model\Customer\Message\CreateCustomerMessage;

class CreateCustomerMessageHandler
{
    /**
     * @var CustomerGatewayInterface
     */
    private $customerGateway;

    /**
     * @var EventCollector
     */
    private $eventCollector;

    public function __construct(
        CustomerGatewayInterface $customerGateway,
        EventCollector $eventCollector
    ) {
        $this->customerGateway = $customerGateway;
        $this->eventCollector = $eventCollector;
    }

    public function __invoke(CreateCustomerMessage $message): Customer
    {
        $customer = $this->customerGateway->create(
            $message->getEmail(),
            $message->getPlainPassword(),
            $message->getFirstName(),
            $message->getLastName(),
            $message->getGender(),
            $message->isEnabled()
        );

        $event = new CustomerCreatedEvent($customer);
        $this->eventCollector->push($event::NAME, $event);

        return $customer;
    }
}
