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

class AddItemToCartMessage
{
    /**
     * @var int
     */
    private $cartId;

    /**
     * @var string
     */
    private $variantCode;

    /**
     * @var int
     */
    private $quantity;

    public function __construct(
        int $cartId,
        string $variantCode,
        int $quantity
    ) {
        $this->cartId = $cartId;
        $this->variantCode = $variantCode;
        $this->quantity = $quantity;
    }

    public function getCartId(): int
    {
        return $this->cartId;
    }

    public function getVariantCode(): string
    {
        return $this->variantCode;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
