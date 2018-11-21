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

class RemoveCartMessage
{
    /**
     * @var int
     */
    private $cartId;

    public function __construct(int $cartId)
    {
        $this->cartId = $cartId;
    }

    public function getCartId(): int
    {
        return $this->cartId;
    }
}
