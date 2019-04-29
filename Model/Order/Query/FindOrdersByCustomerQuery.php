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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Order\Query;

use Sulu\Bundle\SyliusConsumerBundle\Model\Customer\Customer;
use Sulu\Bundle\SyliusConsumerBundle\Model\Customer\CustomerInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\MissingResultException;
use Sulu\Bundle\SyliusConsumerBundle\Model\Order\OrderListInterface;

class FindOrdersByCustomerQuery
{
    /**
     * @var CustomerInterface
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
     * @var \DateTime|null
     */
    private $from;

    /**
     * @var \DateTime|null
     */
    private $to;

    /**
     * @var OrderListInterface|null
     */
    private $orderList;

    public function __construct(
        CustomerInterface $customer,
        ?int $page = null,
        ?int $limit = null,
        \DateTime $from = null,
        \DateTime $to = null
    ) {
        $this->customer = $customer;
        $this->page = $page;
        $this->limit = $limit;
        $this->from = $from;
        $this->to = $to;
    }

    public function getCustomer(): CustomerInterface
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

    public function getFrom(): ?\DateTime
    {
        return $this->from;
    }

    public function getTo(): ?\DateTime
    {
        return $this->to;
    }

    public function getOrderList(): OrderListInterface
    {
        if (!$this->orderList) {
            throw new MissingResultException(__METHOD__);
        }

        return $this->orderList;
    }

    public function setOrderList(OrderListInterface $orderList): self
    {
        $this->orderList = $orderList;

        return $this;
    }
}
