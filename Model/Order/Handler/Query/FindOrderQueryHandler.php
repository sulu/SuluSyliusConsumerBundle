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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Order\Handler\Query;

use Sulu\Bundle\SyliusConsumerBundle\Gateway\OrderGatewayInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Customer\Factory\CustomerFactoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Order\Query\FindOrderQuery;

class FindOrderQueryHandler
{
    /**
     * @var OrderGatewayInterface
     */
    private $orderGateway;

    /**
     * @var CustomerFactoryInterface
     */
    private $customerFactory;

    public function __construct(OrderGatewayInterface $orderGateway, CustomerFactoryInterface $customerFactory)
    {
        $this->orderGateway = $orderGateway;
        $this->customerFactory = $customerFactory;
    }

    public function __invoke(FindOrderQuery $query): void
    {
        $order = $this->orderGateway->findById($query->getId());

        $customer = $this->customerFactory->createFromArray($order['customer']);

        $query->setOrder($order);
        $query->setCustomer($customer);
    }
}
