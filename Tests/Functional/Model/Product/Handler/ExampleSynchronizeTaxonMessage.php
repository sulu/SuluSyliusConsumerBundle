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

class ExampleSynchronizeTaxonMessage
{
    public static function getCode(): int
    {
        return 1;
    }

    public static function getPayload(): array
    {
        return json_decode(
'{
    "name": "Category",
    "id": 1,
    "code": "category",
    "children": [
        {
            "name": "Stickers",
            "id": 3,
            "code": "stickers",
            "children": [],
            "left": 4,
            "right": 5,
            "level": 1,
            "position": 0,
            "translations": {
                "de": {
                    "locale": "de",
                    "id": 3,
                    "name": "Stickers",
                    "slug": "stickers",
                    "description": "Recusandae necessitatibus magnam dolores rerum dolorem facere modi velit. Sit aliquam rerum quo nihil ea provident consectetur impedit. Natus voluptas sint reiciendis aliquam porro consectetur enim."
                }
            },
            "images": [],
            "_links": {
                "self": {
                    "href": "/api/v1/taxons/stickers"
                }
            }
        },
        {
            "name": "T-Shirts",
            "id": 5,
            "code": "t_shirts",
            "children": [
                {
                    "name": "Men",
                    "id": 6,
                    "code": "mens_t_shirts",
                    "children": [],
                    "left": 9,
                    "right": 10,
                    "level": 2,
                    "position": 0,
                    "translations": {
                        "de": {
                            "locale": "de",
                            "id": 6,
                            "name": "Men",
                            "slug": "t-shirts/men",
                            "description": "Iusto aut dolore dolores voluptatibus laboriosam. Dolor et pariatur quaerat vitae. Cupiditate eum culpa qui provident."
                        }
                    },
                    "images": [],
                    "_links": {
                        "self": {
                            "href": "/api/v1/taxons/mens_t_shirts"
                        }
                    }
                },
                {
                    "name": "Womenx",
                    "id": 7,
                    "code": "womens_t_shirts",
                    "children": [],
                    "left": 11,
                    "right": 12,
                    "level": 2,
                    "position": 1,
                    "translations": {
                        "de": {
                            "locale": "de",
                            "id": 7,
                            "name": "Womenx",
                            "slug": "t-shirts/women",
                            "description": "Ut nihil aut est eos. Porro suscipit recusandae optio quia quia laboriosam. Dolore saepe quis vel aut."
                        }
                    },
                    "images": [],
                    "_links": {
                        "self": {
                            "href": "/api/v1/taxons/womens_t_shirts"
                        }
                    }
                }
            ],
            "left": 8,
            "right": 13,
            "level": 1,
            "position": 1,
            "translations": {
                "de": {
                    "locale": "de",
                    "id": 5,
                    "name": "T-Shirts",
                    "slug": "t-shirts",
                    "description": "Aut magnam totam vero rem sed. Ratione saepe aut sint aut magni. Perspiciatis enim accusamus et. Dolores non et fugit culpa ipsum voluptatem vel officia."
                }
            },
            "images": [],
            "_links": {
                "self": {
                    "href": "/api/v1/taxons/t_shirts"
                }
            }
        },
        {
            "name": "Mugs",
            "id": 2,
            "code": "mugs",
            "children": [],
            "left": 2,
            "right": 3,
            "level": 1,
            "position": 2,
            "translations": {
                "de": {
                    "locale": "de",
                    "id": 2,
                    "name": "Mugs",
                    "slug": "mugs",
                    "description": "Molestiae sequi rerum velit beatae officia. Veniam reprehenderit sint quia sit voluptatem. Et ut voluptatem odit non enim quo. Dignissimos magnam quibusdam natus porro sapiente libero distinctio."
                }
            },
            "images": [],
            "_links": {
                "self": {
                    "href": "/api/v1/taxons/mugs"
                }
            }
        },
        {
            "name": "Books",
            "id": 4,
            "code": "books",
            "children": [],
            "left": 6,
            "right": 7,
            "level": 1,
            "position": 3,
            "translations": {
                "de": {
                    "locale": "de",
                    "id": 4,
                    "name": "Books",
                    "slug": "books",
                    "description": "Sit et ipsa quia aspernatur ullam ea. Qui dignissimos cum ipsum nobis. In omnis nulla ea iusto debitis nihil."
                }
            },
            "images": [],
            "_links": {
                "self": {
                    "href": "/api/v1/taxons/books"
                }
            }
        }
    ],
    "left": 1,
    "right": 14,
    "level": 0,
    "position": 0,
    "translations": {
        "de": {
            "locale": "de",
            "id": 1,
            "name": "Kategorie",
            "slug": "category",
            "description": "Deutsche coole Beschreibung"
        },
        "en": {
            "locale": "en",
            "id": 8,
            "name": "Category",
            "slug": "fasdfasd"
        }
    },
    "images": [],
    "_links": {
        "self": {
            "href": "/api/v1/taxons/category"
        }
    }
}', true);
    }
}