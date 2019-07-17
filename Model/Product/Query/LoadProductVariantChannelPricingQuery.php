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

use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductVariantChannelPricing;

class LoadProductVariantChannelPricingQuery
{
    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $channel;

    /**
     * @var ProductVariantChannelPricing
     */
    private $channelPricing;

    public function __construct(string $code, string $channel)
    {
        $this->code = $code;
        $this->channel = $channel;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getChannel(): string
    {
        return $this->channel;
    }

    /**
     * @return ProductVariantChannelPricing
     */
    public function getChannelPricing(): ChannelPricing
    {
        return $this->channelPricing;
    }

    /**
     * @param ProductVariantChannelPricing $channelPricing
     *
     * @return self
     */
    public function setChannelPricing(ProductVariantChannelPricing $channelPricing): self
    {
        $this->channelPricing = $channelPricing;

        return $this;
    }
}
