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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Customer\Message;

use Sulu\Bundle\SyliusConsumerBundle\Model\Customer\CustomerInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\MissingResultException;

class VerifyCustomerMessage
{
    /**
     * @var string
     */
    private $token;

    /**
     * @var CustomerInterface|null
     */
    private $customer;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function getToken(): string
    {
        return $this->token;
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
}
