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

namespace Sulu\Bundle\SyliusConsumerBundle\Tests;

final class MockSyliusData
{
    const TAXON = [
        'name' => 'Category',
        'id' => 1,
        'code' => 'MENU_CATEGORY',
        'children' => [
            [
                'name' => 'T-shirts',
                'id' => 2,
                'code' => 't_shirts',
                'children' => [
                    [
                        'name' => 'Men',
                        'id' => 3,
                        'code' => 'mens_t_shirts',
                        'children' => [],
                        'left' => 3,
                        'right' => 4,
                        'level' => 2,
                        'position' => 0,
                        'translations' => [
                            'en_US' => [
                                'locale' => 'en_US',
                                'id' => 18,
                                'name' => 'necessitatibus optio labore',
                                'slug' => 't-shirts/necessitatibus-optio-labore',
                                'description' => 'Illo nihil autem id eum. Quisquam nostrum reiciendis et ut deserunt. Facere molestias saepe facere vel. Expedita odio et cum quis alias.',
                            ],
                        ],
                        'images' => [],
                    ],
                ],
                'left' => 2,
                'right' => 7,
                'level' => 1,
                'position' => 0,
                'translations' => [
                    'en_US' => [
                        'locale' => 'en_US',
                        'id' => 10,
                        'name' => 'T-shirts',
                        'slug' => 't-shirts',
                        'description' => 'Ea non autem odio. Quasi reprehenderit molestias ab voluptatem impedit eius voluptatem velit. Deserunt impedit asperiores consequuntur error itaque molestias. Modi quia assumenda et est consequuntur commodi.',
                    ],
                ],
                'images' => [],
            ],
        ],
        'left' => 1,
        'right' => 22,
        'level' => 0,
        'position' => 0,
        'translations' => [
            'en_US' => [
                'locale' => 'en_US',
                'id' => 2,
                'name' => 'Category',
                'slug' => 'category',
                'description' => 'Soluta deleniti dolore tenetur. Odio voluptatibus excepturi quas autem totam odio dolorum. Sed aut at cum quia recusandae. Quos eos iusto sed sed occaecati.',
            ],
        ],
        'images' => [],
    ];
}
