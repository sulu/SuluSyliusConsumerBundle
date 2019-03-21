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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Address\Handler\Query;

use Sulu\Bundle\SyliusConsumerBundle\Gateway\AddressGatewayInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Address\Factory\AddressFactoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Address\Query\FindAddressQuery;

class FindAddressQueryHandler
{
    /**
     * @var AddressGatewayInterface
     */
    private $addressGateway;

    /**
     * @var AddressFactoryInterface
     */
    private $addressFactory;

    public function __construct(
        AddressGatewayInterface $addressGateway,
        AddressFactoryInterface $addressFactory
    ) {
        $this->addressGateway = $addressGateway;
        $this->addressFactory = $addressFactory;
    }

    public function __invoke(FindAddressQuery $message): void
    {
        $gatewayResponse = $this->addressGateway->findById($message->getId());

        $address = $this->addressFactory->createFromArray($gatewayResponse);

        $message->setAddress($address);
    }
}
