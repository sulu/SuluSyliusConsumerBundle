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
use Sulu\Bundle\SyliusConsumerBundle\Model\Order\OrderList;
use Sulu\Bundle\SyliusConsumerBundle\Model\Order\Query\FindOrdersByCustomerMessage;

class FindOrdersByCustomerQueryHandler
{
    /**
     * @var OrderGatewayInterface
     */
    private $orderGateway;

    public function __construct(OrderGatewayInterface $orderGateway)
    {
        $this->orderGateway = $orderGateway;
    }

    public function __invoke(FindOrdersByCustomerMessage $message): void
    {
        $gatewayResponse = $this->orderGateway->findByCustomer(
            $message->getCustomer()->getId(),
            $message->getLimit(),
            $message->getPage(),
            $message->getFrom(),
            $message->getTo()
        );

        $orderList = new OrderList(
            $gatewayResponse['page'],
            $gatewayResponse['limit'],
            $gatewayResponse['pages'],
            $gatewayResponse['total'],
            $gatewayResponse['_embedded']['items']
        );

        $message->setOrderList($orderList);
    }
}
