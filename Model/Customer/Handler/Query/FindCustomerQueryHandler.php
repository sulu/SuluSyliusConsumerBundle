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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Customer\Handler\Query;

use Sulu\Bundle\SyliusConsumerBundle\Gateway\CustomerGatewayInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Customer\Query\FindCustomerQuery;

class FindCustomerQueryHandler
{
    /**
     * @var CustomerGatewayInterface
     */
    private $customerGateway;

    public function __construct(CustomerGatewayInterface $customerGateway)
    {
        $this->customerGateway = $customerGateway;
    }

    public function __invoke(FindCustomerQuery $message): void
    {
        $customer = $this->customerGateway->findById($message->getId());

        $message->setCustomer($customer);
    }
}
