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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Address\Query;

use Sulu\Bundle\SyliusConsumerBundle\Model\Address\AddressListInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Customer\Customer;
use Sulu\Bundle\SyliusConsumerBundle\Model\MissingResultException;

class FindAddressesByCustomerQuery
{
    /**
     * @var Customer
     */
    private $customer;

    /**
     * @var int|null
     */
    private $page;

    /**
     * @var int|null
     */
    private $limit;

    /**
     * @var AddressListInterface|null
     */
    private $addressList;

    public function __construct(
        Customer $customer,
        ?int $page = null,
        ?int $limit = null
    ) {
        $this->customer = $customer;
        $this->page = $page;
        $this->limit = $limit;
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    public function getPage(): ?int
    {
        return $this->page;
    }

    public function getLimit(): ?int
    {
        return $this->limit;
    }

    public function getAddressList(): AddressListInterface
    {
        if (!$this->addressList) {
            throw new MissingResultException(__METHOD__);
        }

        return $this->addressList;
    }

    public function setAddressList(AddressListInterface $addressList): self
    {
        $this->addressList = $addressList;

        return $this;
    }
}
