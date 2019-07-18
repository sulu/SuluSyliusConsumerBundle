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
namespace Sulu\Bundle\SyliusConsumerBundle\Tests\Functional\Model\Product\Handler;

use GuzzleHttp\Psr7\Response;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Query\LoadProductVariantChannelPricingQuery;
use Sulu\Bundle\SyliusConsumerBundle\Tests\Functional\FunctionalTestCate;

class LoadProductVariantChannelPricingQueryTest extends FunctionalTestCate
{
    public function testFindByCodeAndVariant()
    {
        $this->getGatewayClient()->setHandleRequestCallable(
            function ($method, $uri, array $options = []) {
                $this->assertEquals('GET', $method);
                $this->assertEquals('/api/v1/products/PRODUCT1/variants/VARIANT1', $uri);

                return new Response(
                    200,
                    [],
                    '{
                       "id":1,
                       "code":"VARIANT1",
                       "optionValues":[],
                       "position":0,
                       "translations":{
                          "en_US":{
                             "locale":"en_US",
                             "id":1
                          }
                       },
                       "version":1,
                       "onHold":0,
                       "onHand":99,
                       "tracked":false,
                       "channelPricings":{
                          "channel-2":{
                             "channelCode":"channel-2",
                             "price":1995
                          },
                          "default":{
                             "channelCode":"default",
                             "price":995
                          }
                       }
                     }'
                );
            }
        );

        $query = $query = new LoadProductVariantChannelPricingQuery('PRODUCT1', 'VARIANT1', 'channel-2');
        $this->getMessageBus()->dispatch($query);

        $channelPrice = $query->getPrice();
        $this->assertEquals('1995', $channelPrice);
    }
}
