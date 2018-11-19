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
use Sulu\Bundle\SyliusConsumerBundle\Model\Cart\Message\AddItemToCartMessage;

class AddItemToCartMessageHandler
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

    public function __invoke(AddItemToCartMessage $message): array
    {
        $cartId = $this->getCartId($message);
        $item = $this->cartGateway->addItem($cartId, $message->getVariantCode(), $message->getQuantity());

        return $item;
    }

    private function getCartId(AddItemToCartMessage $message): int
    {
        $cartId = $message->getCartId();
        if ($cartId) {
            return $cartId;
        }

        $syliusUser = $message->getSyliusUser();
        if (!$syliusUser) {
            // TODO: Anonymous Cart
            throw new \Exception('not implemented');
        }

        $createdCart = $this->cartGateway->create(
            $syliusUser->getEmail(),
            $this->defaultChannel,
            $message->getLocale()
        );

        return $createdCart['id'];
    }
}
