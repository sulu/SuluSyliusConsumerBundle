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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Customer\Event;

use Sulu\Bundle\SyliusConsumerBundle\Model\Customer\CustomerInterface;
use Symfony\Contracts\EventDispatcher\Event;

abstract class CustomerEvent extends Event
{
    /**
     * @var CustomerInterface
     */
    private $customer;

    public function __construct(CustomerInterface $customer)
    {
        $this->customer = $customer;
    }

    public function getCustomer(): CustomerInterface
    {
        return $this->customer;
    }
}
