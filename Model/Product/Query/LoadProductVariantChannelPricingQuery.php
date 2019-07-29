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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Product\Query;

class LoadProductVariantChannelPricingQuery
{
    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $variantCode;

    /**
     * @var string
     */
    private $channel;

    /**
     * @var int
     */
    private $price;

    public function __construct(string $code, string $variantCode, string $channel)
    {
        $this->code = $code;
        $this->variantCode = $variantCode;
        $this->channel = $channel;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getVariantCode(): string
    {
        return $this->variantCode;
    }

    public function getChannel(): string
    {
        return $this->channel;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }
}
