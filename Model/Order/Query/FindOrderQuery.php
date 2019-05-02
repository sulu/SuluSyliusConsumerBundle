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

use Sulu\Bundle\SyliusConsumerBundle\Model\Customer\CustomerInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\MissingResultException;

class FindOrderQuery
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var CustomerInterface|null
     */
    private $customer;

    /**
     * @var array|null
     */
    private $order;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCustomer(): CustomerInterface
    {
        if (!$this->customer) {
            throw new MissingResultException(__METHOD__);
        }

        return $this->customer;
    }

    public function setCustomer(CustomerInterface $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getOrder(): array
    {
        if (null === $this->order) {
            throw new MissingResultException(__METHOD__);
        }

        return $this->order;
    }

    public function setOrder(array $order): self
    {
        $this->order = $order;

        return $this;
    }
}
