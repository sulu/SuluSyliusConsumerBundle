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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Cart\Query;

use Sulu\Bundle\SyliusConsumerBundle\Model\MissingResultException;

class FindCartMessage
{
    /**
     * @var int
     */
    private $cartId;

    /**
     * @var array|null
     */
    private $cart;

    public function __construct(int $cartId)
    {
        $this->cartId = $cartId;
    }

    public function getCartId(): int
    {
        return $this->cartId;
    }

    public function getCart(): array
    {
        if (null === $this->cart) {
            throw new MissingResultException(__METHOD__);
        }

        return $this->cart;
    }

    public function setCart(array $cart): self
    {
        $this->cart = $cart;

        return $this;
    }
}
