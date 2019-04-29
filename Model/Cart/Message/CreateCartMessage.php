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

use Sulu\Bundle\SyliusConsumerBundle\Model\Customer\CustomerInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\MissingResultException;

class CreateCartMessage
{
    /**
     * @var CustomerInterface|null
     */
    private $customer;

    /**
     * @var string
     */
    private $locale;

    /**
     * @var string|null
     */
    private $channel;

    /**
     * @var array|null
     */
    private $cart;

    public function __construct(
        ?CustomerInterface $customer,
        string $locale,
        string $channel = null
    ) {
        $this->customer = $customer;
        $this->locale = $locale;
        $this->channel = $channel;
    }

    public function getCustomer(): ?CustomerInterface
    {
        return $this->customer;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function getChannel(): ?string
    {
        return $this->channel;
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
