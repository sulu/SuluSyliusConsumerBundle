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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Cart\Handler\Query;

use Sulu\Bundle\SyliusConsumerBundle\Gateway\CartGatewayInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Cart\Query\FindCartMessage;

class FindCartMessageHandler
{
    /**
     * @var CartGatewayInterface
     */
    private $cartGateway;

    public function __construct(CartGatewayInterface $cartGateway)
    {
        $this->cartGateway = $cartGateway;
    }

    public function __invoke(FindCartMessage $message): void
    {
        $cart = $this->cartGateway->findById($message->getCartId());

        $message->setCart($cart);
    }
}
