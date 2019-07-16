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


use Sulu\Bundle\SyliusConsumerBundle\Gateway\ProductPriceGatewayInterface;

class LoadProductChannelPricingQueryHandler
{
    /**
     * @var ProductPriceGatewayInterface
     */
    private $productPriceGateway;

    public function __construct(ProductPriceGatewayInterface $productPriceGateway)
    {
        $this->productPriceGateway = $productPriceGateway;
    }

    public function __invoke(FindCustomerQuery $query): void
    {
        $this->productPriceGateway->findByCode($query->getId());
    }
}
