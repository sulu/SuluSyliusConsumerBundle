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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Address\Handler\Message;

use Sulu\Bundle\SyliusConsumerBundle\Gateway\AddressGatewayInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Address\Factory\AddressFactory;
use Sulu\Bundle\SyliusConsumerBundle\Model\Address\Message\CreateAddressMessage;

class CreateAddressMessageHandler
{
    /**
     * @var AddressGatewayInterface
     */
    private $addressGateway;

    /**
     * @var AddressFactory
     */
    private $addressFactory;

    public function __construct(AddressGatewayInterface $addressGateway, AddressFactory $addressFactory)
    {
        $this->addressGateway = $addressGateway;
        $this->addressFactory = $addressFactory;
    }

    public function __invoke(CreateAddressMessage $message): void
    {
        $gatewayResponse = $this->addressGateway->create($message->getCustomer()->getId(), $message->getAddress());

        $result = $this->addressFactory->createFromArray($gatewayResponse);

        $message->setResult($result);
    }
}
