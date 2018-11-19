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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Cart\Handler\Message;

use Sulu\Bundle\SyliusConsumerBundle\Gateway\CartGateway;
use Sulu\Bundle\SyliusConsumerBundle\Model\Cart\Message\RemoveItemFromCartMessage;

class RemoveItemFromCartMessageHandler
{
    /**
     * @var CartGateway
     */
    private $cartGateway;

    /**
     * @var string
     */
    private $defaultChannel;

    public function __construct(CartGateway $cartGateway, string $defaultChannel)
    {
        $this->cartGateway = $cartGateway;
        $this->defaultChannel = $defaultChannel;
    }

    public function __invoke(RemoveItemFromCartMessage $message): array
    {
        return $this->cartGateway->deleteItem($message->getCartId(), $message->getCartItemId());
    }
}
