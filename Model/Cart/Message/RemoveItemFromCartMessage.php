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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Cart\Message;

class RemoveItemFromCartMessage
{
    /**
     * @var int
     */
    private $cartId;

    /**
     * @var int
     */
    private $cartItemId;

    public function __construct(
        int $cartId,
        int $cartItemId
    ) {
        $this->cartId = $cartId;
        $this->cartItemId = $cartItemId;
    }

    public function getCartId(): int
    {
        return $this->cartId;
    }

    public function getCartItemId(): int
    {
        return $this->cartItemId;
    }
}
