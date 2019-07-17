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


use Sulu\Bundle\SyliusConsumerBundle\Gateway\ProductVariantChannelPricingGatewayInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Query\LoadProductVariantChannelPricingQuery;

class LoadProductVariantChannelPricingQueryHandler
{
    /**
     * @var ProductVariantChannelPricingGatewayInterface
     */
    private $productVariantChannelPricingGateway;

    public function __construct(ProductVariantChannelPricingGatewayInterface $productChannelPricingGateway)
    {
        $this->productVariantChannelPricingGateway = $productChannelPricingGateway;
    }

    public function __invoke(LoadProductVariantChannelPricingQuery $query): void
    {
        $channelPricings = $this->productVariantChannelPricingGateway->findByCode($query->getCode());
    }
}
