<?php

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Customer\Event;

use Sulu\Bundle\SyliusConsumerBundle\Model\Customer\Customer;
use Symfony\Component\EventDispatcher\Event;

abstract class CustomerEvent extends Event
{
    const NAME = self::NAME;

    /**
     * @var Customer
     */
    private $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }
}
