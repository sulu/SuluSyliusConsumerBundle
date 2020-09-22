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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Product\Handler\Query;

use Sulu\Bundle\SyliusConsumerBundle\Gateway\ProductVariantGatewayInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Query\LoadProductVariantChannelPricingQuery;

class LoadProductVariantChannelPricingQueryHandler
{
    /**
     * @var ProductVariantGatewayInterface
     */
    private $gateway;

    public function __construct(ProductVariantGatewayInterface $productVariantGateway)
    {
        $this->gateway = $productVariantGateway;
    }

    public function __invoke(LoadProductVariantChannelPricingQuery $query): void
    {
        $variantData = $this->gateway->findByCodeAndVariantCode(
            $query->getCode(),
            $query->getVariantCode()
        );

        foreach ($variantData['channelPricings'] as $channelPricing) {
            if ($query->getChannel() === $channelPricing['channelCode']) {
                $query->setPrice($channelPricing['price']);
            }
        }
    }
}
