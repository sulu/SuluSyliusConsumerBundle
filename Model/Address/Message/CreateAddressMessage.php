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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Address\Message;

use Sulu\Bundle\SyliusConsumerBundle\Model\Address\AddressInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Customer\CustomerInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\MissingResultException;

class CreateAddressMessage
{
    /**
     * @var CustomerInterface
     */
    private $customer;

    /**
     * @var AddressInterface
     */
    private $address;

    /**
     * @var AddressInterface|null
     */
    private $result;

    public function __construct(
        CustomerInterface $customer,
        AddressInterface $address
    ) {
        $this->customer = $customer;
        $this->address = $address;
    }

    public function getCustomer(): CustomerInterface
    {
        return $this->customer;
    }

    public function getAddress(): AddressInterface
    {
        return $this->address;
    }

    public function getResult(): AddressInterface
    {
        if (null === $this->result) {
            throw new MissingResultException(__METHOD__);
        }

        return $this->result;
    }

    public function setResult(AddressInterface $result): self
    {
        $this->result = $result;

        return $this;
    }
}
