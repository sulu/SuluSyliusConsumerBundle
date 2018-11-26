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

class ExampleSynchronizeProductMessage
{
    public static function getCode(): string
    {
        return '00-01-080';
    }

    public static function getPayload(): array
    {
        return [
            'id' => 3573,
            'code' => '00-01-080',
            'enabled' => false,
            'mainTaxonId' => null,
            'productTaxons' => [
                [
                    'id' => 24229,
                    'taxonId' => 22,
                    'position' => 3,
                ],
            ],
            'translations' => [
                [
                    'locale' => 'de',
                    'name' => 'SB verpackt zu je 1',
                    'slug' => 'sb-verpackt-zu-je-1-00-01-080',
                    'description' => 'SB verpackt zu je 1',
                    'shortDescription' => null,
                    'metaKeywords' => null,
                    'metaDescription' => null,
                    'customData' => [
                        'unit' => null,
                        'marketingText' => null,
                    ],
                ],
                [
                    'locale' => 'en',
                    'name' => 'SB verpackt zu je 1',
                    'slug' => 'sb-verpackt-zu-je-1-00-01-080',
                    'description' => 'SB verpackt zu je 1',
                    'shortDescription' => null,
                    'metaKeywords' => null,
                    'metaDescription' => null,
                    'customData' => [
                        'unit' => null,
                        'marketingText' => null,
                    ],
                ],
                [
                    'locale' => 'fr',
                    'name' => 'emballer SB à 1 pcs',
                    'slug' => 'emballer-sb-a-1-pcs-00-01-080',
                    'description' => 'emballer SB à 1 pcs',
                    'shortDescription' => null,
                    'metaKeywords' => null,
                    'metaDescription' => null,
                    'customData' => [
                        'unit' => null,
                        'marketingText' => null,
                    ],
                ],
                [
                    'locale' => 'it',
                    'name' => 'imballato SB a 1 pz',
                    'slug' => 'imballato-sb-a-1-pz-00-01-080',
                    'description' => 'imballato SB a 1 pz',
                    'shortDescription' => null,
                    'metaKeywords' => null,
                    'metaDescription' => null,
                    'customData' => [
                        'unit' => null,
                        'marketingText' => null,
                    ],
                ],
            ],
            'attributes' => [],
            'images' => [],
            'customData' => [
                'unit' => null,
                'marketingText' => null,
            ],
        ];
    }
}
