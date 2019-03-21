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
use Sulu\Bundle\SyliusConsumerBundle\Model\Address\AddressList;
use Sulu\Bundle\SyliusConsumerBundle\Model\Address\Factory\AddressFactory;
use Sulu\Bundle\SyliusConsumerBundle\Model\Address\Query\FindAddressesByCustomerQuery;

class FindAddressesByCustomerQueryHandler
{
    /**
     * @var AddressGatewayInterface
     */
    private $addressGateway;

    /**
     * @var AddressFactory
     */
    private $addressFactory;

    /**
     * @var int
     */
    private $defaultLimit;

    public function __construct(
        AddressGatewayInterface $addressGateway,
        AddressFactory $addressFactory,
        int $defaultLimit
    ) {
        $this->addressGateway = $addressGateway;
        $this->addressFactory = $addressFactory;
        $this->defaultLimit = $defaultLimit;
    }

    public function __invoke(FindAddressesByCustomerQuery $message): void
    {
        $gatewayResponse = $this->addressGateway->findByCustomer(
            $message->getCustomer()->getId(),
            $message->getLimit() ?? $this->defaultLimit,
            $message->getPage() ?? 1
        );

        $addressList = new AddressList(
            $gatewayResponse['page'],
            $gatewayResponse['limit'],
            $gatewayResponse['pages'],
            $gatewayResponse['total'],
            $this->createAddresses($gatewayResponse['_embedded']['items'])
        );

        $message->setAddressList($addressList);
    }

    private function createAddresses(array $items): array
    {
        $addresses = [];
        foreach ($items as $item) {
            $addresses[] = $this->addressFactory->createFromArray($item);
        }

        return $addresses;
    }
}
