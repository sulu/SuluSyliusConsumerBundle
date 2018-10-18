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

class ExampleSynchronizeProductMessage {
    static function getCode(): string {
        return '0602fd01-1e26-313f-9544-420369277dd6';
    }

    static function getPayload(): array {
        return json_decode('{
    "name": "T-Shirt \"nihil\"",
    "id": 53,
    "code": "0602fd01-1e26-313f-9544-420369277dd6",
    "attributes": [
        {
            "code": "t_shirt_brand",
            "name": "T-Shirt brand",
            "value": "Nike",
            "type": "text",
            "id": 127,
            "localeCode": "de"
        },
        {
            "code": "t_shirt_collection",
            "name": "T-Shirt collection",
            "value": "Sylius Autumn 1995",
            "type": "text",
            "id": 128,
            "localeCode": "de"
        },
        {
            "code": "t_shirt_material",
            "name": "T-Shirt material",
            "value": "Potato 100%",
            "type": "text",
            "id": 129,
            "localeCode": "de"
        }
    ],
    "options": [
        {
            "id": 3,
            "code": "t_shirt_color",
            "position": 2,
            "values": [
                {
                    "code": "t_shirt_color_red",
                    "translations": {
                        "de": {
                            "locale": "de",
                            "id": 7,
                            "value": "Red"
                        }
                    }
                },
                {
                    "code": "t_shirt_color_black",
                    "translations": {
                        "de": {
                            "locale": "de",
                            "id": 8,
                            "value": "Black"
                        }
                    }
                },
                {
                    "code": "t_shirt_color_white",
                    "translations": {
                        "de": {
                            "locale": "de",
                            "id": 9,
                            "value": "White"
                        }
                    }
                }
            ],
            "translations": {
                "de": {
                    "locale": "de",
                    "id": 3,
                    "name": "T-Shirt color"
                }
            },
            "_links": {
                "self": {
                    "href": "/api/v1/product-options/t_shirt_color"
                }
            }
        },
        {
            "id": 4,
            "code": "t_shirt_size",
            "position": 3,
            "values": [
                {
                    "code": "t_shirt_size_s",
                    "translations": {
                        "de": {
                            "locale": "de",
                            "id": 10,
                            "value": "S"
                        }
                    }
                },
                {
                    "code": "t_shirt_size_m",
                    "translations": {
                        "de": {
                            "locale": "de",
                            "id": 11,
                            "value": "M"
                        }
                    }
                },
                {
                    "code": "t_shirt_size_l",
                    "translations": {
                        "de": {
                            "locale": "de",
                            "id": 12,
                            "value": "L"
                        }
                    }
                },
                {
                    "code": "t_shirt_size_xl",
                    "translations": {
                        "de": {
                            "locale": "de",
                            "id": 13,
                            "value": "XL"
                        }
                    }
                },
                {
                    "code": "t_shirt_size_xxl",
                    "translations": {
                        "de": {
                            "locale": "de",
                            "id": 14,
                            "value": "XXL"
                        }
                    }
                }
            ],
            "translations": {
                "de": {
                    "locale": "de",
                    "id": 4,
                    "name": "T-Shirt size"
                }
            },
            "_links": {
                "self": {
                    "href": "/api/v1/product-options/t_shirt_size"
                }
            }
        }
    ],
    "associations": [
        {
            "id": 8,
            "type": {
                "id": 1,
                "code": "similar_products",
                "createdAt": "2018-10-16T14:20:44+02:00",
                "updatedAt": "2018-10-16T14:20:44+02:00",
                "translations": {
                    "de": {
                        "locale": "de",
                        "id": 1,
                        "name": "Similar products"
                    }
                },
                "_links": {
                    "self": {
                        "href": "/api/v1/product-association-types/similar_products"
                    }
                }
            },
            "associatedProducts": [
                {
                    "name": "T-Shirt \"perspiciatis\"",
                    "id": 49,
                    "code": "7b704b89-f97e-3a05-92ec-322b04724201",
                    "attributes": [
                        {
                            "code": "t_shirt_brand",
                            "name": "T-Shirt brand",
                            "value": "Adidas",
                            "type": "text",
                            "id": 115,
                            "localeCode": "de"
                        },
                        {
                            "code": "t_shirt_collection",
                            "name": "T-Shirt collection",
                            "value": "Sylius Winter 1999",
                            "type": "text",
                            "id": 116,
                            "localeCode": "de"
                        },
                        {
                            "code": "t_shirt_material",
                            "name": "T-Shirt material",
                            "value": "Centipede 10% / Wool 90%",
                            "type": "text",
                            "id": 117,
                            "localeCode": "de"
                        }
                    ],
                    "options": [
                        {
                            "id": 3,
                            "code": "t_shirt_color",
                            "position": 2,
                            "values": [
                                {
                                    "code": "t_shirt_color_red",
                                    "translations": {
                                        "de": {
                                            "locale": "de",
                                            "id": 7,
                                            "value": "Red"
                                        }
                                    }
                                },
                                {
                                    "code": "t_shirt_color_black",
                                    "translations": {
                                        "de": {
                                            "locale": "de",
                                            "id": 8,
                                            "value": "Black"
                                        }
                                    }
                                },
                                {
                                    "code": "t_shirt_color_white",
                                    "translations": {
                                        "de": {
                                            "locale": "de",
                                            "id": 9,
                                            "value": "White"
                                        }
                                    }
                                }
                            ],
                            "translations": {
                                "de": {
                                    "locale": "de",
                                    "id": 3,
                                    "name": "T-Shirt color"
                                }
                            },
                            "_links": {
                                "self": {
                                    "href": "/api/v1/product-options/t_shirt_color"
                                }
                            }
                        },
                        {
                            "id": 4,
                            "code": "t_shirt_size",
                            "position": 3,
                            "values": [
                                {
                                    "code": "t_shirt_size_s",
                                    "translations": {
                                        "de": {
                                            "locale": "de",
                                            "id": 10,
                                            "value": "S"
                                        }
                                    }
                                },
                                {
                                    "code": "t_shirt_size_m",
                                    "translations": {
                                        "de": {
                                            "locale": "de",
                                            "id": 11,
                                            "value": "M"
                                        }
                                    }
                                },
                                {
                                    "code": "t_shirt_size_l",
                                    "translations": {
                                        "de": {
                                            "locale": "de",
                                            "id": 12,
                                            "value": "L"
                                        }
                                    }
                                },
                                {
                                    "code": "t_shirt_size_xl",
                                    "translations": {
                                        "de": {
                                            "locale": "de",
                                            "id": 13,
                                            "value": "XL"
                                        }
                                    }
                                },
                                {
                                    "code": "t_shirt_size_xxl",
                                    "translations": {
                                        "de": {
                                            "locale": "de",
                                            "id": 14,
                                            "value": "XXL"
                                        }
                                    }
                                }
                            ],
                            "translations": {
                                "de": {
                                    "locale": "de",
                                    "id": 4,
                                    "name": "T-Shirt size"
                                }
                            },
                            "_links": {
                                "self": {
                                    "href": "/api/v1/product-options/t_shirt_size"
                                }
                            }
                        }
                    ],
                    "associations": [
                        {
                            "id": 1,
                            "type": {
                                "id": 1,
                                "code": "similar_products",
                                "createdAt": "2018-10-16T14:20:44+02:00",
                                "updatedAt": "2018-10-16T14:20:44+02:00",
                                "translations": {
                                    "de": {
                                        "locale": "de",
                                        "id": 1,
                                        "name": "Similar products"
                                    }
                                },
                                "_links": {
                                    "self": {
                                        "href": "/api/v1/product-association-types/similar_products"
                                    }
                                }
                            },
                            "associatedProducts": {
                                "0": {
                                    "name": "T-Shirt \"cumque\"",
                                    "id": 50,
                                    "code": "a6135868-6dd1-39a7-8b2b-ab800d6d6f8f",
                                    "attributes": [
                                        {
                                            "code": "t_shirt_brand",
                                            "name": "T-Shirt brand",
                                            "value": "JKM-476 Streetwear",
                                            "type": "text",
                                            "id": 118,
                                            "localeCode": "de"
                                        },
                                        {
                                            "code": "t_shirt_collection",
                                            "name": "T-Shirt collection",
                                            "value": "Sylius Spring 2001",
                                            "type": "text",
                                            "id": 119,
                                            "localeCode": "de"
                                        },
                                        {
                                            "code": "t_shirt_material",
                                            "name": "T-Shirt material",
                                            "value": "Centipede",
                                            "type": "text",
                                            "id": 120,
                                            "localeCode": "de"
                                        }
                                    ],
                                    "options": [
                                        {
                                            "id": 3,
                                            "code": "t_shirt_color",
                                            "position": 2,
                                            "values": [
                                                {
                                                    "code": "t_shirt_color_red",
                                                    "translations": {
                                                        "de": {
                                                            "locale": "de",
                                                            "id": 7,
                                                            "value": "Red"
                                                        }
                                                    }
                                                },
                                                {
                                                    "code": "t_shirt_color_black",
                                                    "translations": {
                                                        "de": {
                                                            "locale": "de",
                                                            "id": 8,
                                                            "value": "Black"
                                                        }
                                                    }
                                                },
                                                {
                                                    "code": "t_shirt_color_white",
                                                    "translations": {
                                                        "de": {
                                                            "locale": "de",
                                                            "id": 9,
                                                            "value": "White"
                                                        }
                                                    }
                                                }
                                            ],
                                            "translations": {
                                                "de": {
                                                    "locale": "de",
                                                    "id": 3,
                                                    "name": "T-Shirt color"
                                                }
                                            },
                                            "_links": {
                                                "self": {
                                                    "href": "/api/v1/product-options/t_shirt_color"
                                                }
                                            }
                                        },
                                        {
                                            "id": 4,
                                            "code": "t_shirt_size",
                                            "position": 3,
                                            "values": [
                                                {
                                                    "code": "t_shirt_size_s",
                                                    "translations": {
                                                        "de": {
                                                            "locale": "de",
                                                            "id": 10,
                                                            "value": "S"
                                                        }
                                                    }
                                                },
                                                {
                                                    "code": "t_shirt_size_m",
                                                    "translations": {
                                                        "de": {
                                                            "locale": "de",
                                                            "id": 11,
                                                            "value": "M"
                                                        }
                                                    }
                                                },
                                                {
                                                    "code": "t_shirt_size_l",
                                                    "translations": {
                                                        "de": {
                                                            "locale": "de",
                                                            "id": 12,
                                                            "value": "L"
                                                        }
                                                    }
                                                },
                                                {
                                                    "code": "t_shirt_size_xl",
                                                    "translations": {
                                                        "de": {
                                                            "locale": "de",
                                                            "id": 13,
                                                            "value": "XL"
                                                        }
                                                    }
                                                },
                                                {
                                                    "code": "t_shirt_size_xxl",
                                                    "translations": {
                                                        "de": {
                                                            "locale": "de",
                                                            "id": 14,
                                                            "value": "XXL"
                                                        }
                                                    }
                                                }
                                            ],
                                            "translations": {
                                                "de": {
                                                    "locale": "de",
                                                    "id": 4,
                                                    "name": "T-Shirt size"
                                                }
                                            },
                                            "_links": {
                                                "self": {
                                                    "href": "/api/v1/product-options/t_shirt_size"
                                                }
                                            }
                                        }
                                    ],
                                    "associations": [
                                        {
                                            "id": 7,
                                            "type": {
                                                "id": 1,
                                                "code": "similar_products",
                                                "createdAt": "2018-10-16T14:20:44+02:00",
                                                "updatedAt": "2018-10-16T14:20:44+02:00",
                                                "translations": {
                                                    "de": {
                                                        "locale": "de",
                                                        "id": 1,
                                                        "name": "Similar products"
                                                    }
                                                },
                                                "_links": {
                                                    "self": {
                                                        "href": "/api/v1/product-association-types/similar_products"
                                                    }
                                                }
                                            },
                                            "associatedProducts": [
                                                {
                                                    "name": "T-Shirt \"tempore\"",
                                                    "id": 51,
                                                    "code": "b49a606c-b4c3-3fc9-be6a-28667bda250d",
                                                    "attributes": [
                                                        {
                                                            "code": "t_shirt_brand",
                                                            "name": "T-Shirt brand",
                                                            "value": "Nike",
                                                            "type": "text",
                                                            "id": 121,
                                                            "localeCode": "de"
                                                        },
                                                        {
                                                            "code": "t_shirt_collection",
                                                            "name": "T-Shirt collection",
                                                            "value": "Sylius Winter 2000",
                                                            "type": "text",
                                                            "id": 122,
                                                            "localeCode": "de"
                                                        },
                                                        {
                                                            "code": "t_shirt_material",
                                                            "name": "T-Shirt material",
                                                            "value": "Centipede 10% / Wool 90%",
                                                            "type": "text",
                                                            "id": 123,
                                                            "localeCode": "de"
                                                        }
                                                    ],
                                                    "options": [
                                                        {
                                                            "id": 3,
                                                            "code": "t_shirt_color",
                                                            "position": 2,
                                                            "values": [
                                                                {
                                                                    "code": "t_shirt_color_red",
                                                                    "translations": {
                                                                        "de": {
                                                                            "locale": "de",
                                                                            "id": 7,
                                                                            "value": "Red"
                                                                        }
                                                                    }
                                                                },
                                                                {
                                                                    "code": "t_shirt_color_black",
                                                                    "translations": {
                                                                        "de": {
                                                                            "locale": "de",
                                                                            "id": 8,
                                                                            "value": "Black"
                                                                        }
                                                                    }
                                                                },
                                                                {
                                                                    "code": "t_shirt_color_white",
                                                                    "translations": {
                                                                        "de": {
                                                                            "locale": "de",
                                                                            "id": 9,
                                                                            "value": "White"
                                                                        }
                                                                    }
                                                                }
                                                            ],
                                                            "translations": {
                                                                "de": {
                                                                    "locale": "de",
                                                                    "id": 3,
                                                                    "name": "T-Shirt color"
                                                                }
                                                            },
                                                            "_links": {
                                                                "self": {
                                                                    "href": "/api/v1/product-options/t_shirt_color"
                                                                }
                                                            }
                                                        },
                                                        {
                                                            "id": 4,
                                                            "code": "t_shirt_size",
                                                            "position": 3,
                                                            "values": [
                                                                {
                                                                    "code": "t_shirt_size_s",
                                                                    "translations": {
                                                                        "de": {
                                                                            "locale": "de",
                                                                            "id": 10,
                                                                            "value": "S"
                                                                        }
                                                                    }
                                                                },
                                                                {
                                                                    "code": "t_shirt_size_m",
                                                                    "translations": {
                                                                        "de": {
                                                                            "locale": "de",
                                                                            "id": 11,
                                                                            "value": "M"
                                                                        }
                                                                    }
                                                                },
                                                                {
                                                                    "code": "t_shirt_size_l",
                                                                    "translations": {
                                                                        "de": {
                                                                            "locale": "de",
                                                                            "id": 12,
                                                                            "value": "L"
                                                                        }
                                                                    }
                                                                },
                                                                {
                                                                    "code": "t_shirt_size_xl",
                                                                    "translations": {
                                                                        "de": {
                                                                            "locale": "de",
                                                                            "id": 13,
                                                                            "value": "XL"
                                                                        }
                                                                    }
                                                                },
                                                                {
                                                                    "code": "t_shirt_size_xxl",
                                                                    "translations": {
                                                                        "de": {
                                                                            "locale": "de",
                                                                            "id": 14,
                                                                            "value": "XXL"
                                                                        }
                                                                    }
                                                                }
                                                            ],
                                                            "translations": {
                                                                "de": {
                                                                    "locale": "de",
                                                                    "id": 4,
                                                                    "name": "T-Shirt size"
                                                                }
                                                            },
                                                            "_links": {
                                                                "self": {
                                                                    "href": "/api/v1/product-options/t_shirt_size"
                                                                }
                                                            }
                                                        }
                                                    ],
                                                    "associations": [],
                                                    "translations": {
                                                        "de": {
                                                            "locale": "de",
                                                            "id": 51,
                                                            "name": "T-Shirt \"tempore\"",
                                                            "slug": "t-shirt-tempore",
                                                            "description": "Consequatur debitis quia ullam. Est consequatur facere officia dolor dolores et non. Praesentium quidem eos vel qui sequi autem dolore totam. Quis odio beatae blanditiis nihil tempora.\n\nTotam maxime in culpa voluptatibus ab et. Corporis beatae officia molestiae sapiente aliquid odit veritatis. Ea perferendis suscipit omnis.\n\nSed optio quis qui aut ea laborum est. Tempore ipsam dicta qui sit. Consequuntur deleniti similique debitis eos laboriosam quis. Commodi accusamus aliquid autem qui rerum ratione dolorum et.",
                                                            "shortDescription": "Illum velit repellendus voluptate et vero repudiandae nam. Nemo qui id eaque quia in excepturi libero."
                                                        }
                                                    },
                                                    "productTaxons": [
                                                        {
                                                            "id": 56,
                                                            "taxon": {
                                                                "name": "T-Shirts",
                                                                "id": 5,
                                                                "code": "t_shirts",
                                                                "root": {
                                                                    "name": "Category",
                                                                    "id": 1,
                                                                    "code": "category",
                                                                    "children": [
                                                                        {
                                                                            "name": "Mugs",
                                                                            "id": 2,
                                                                            "code": "mugs",
                                                                            "children": [],
                                                                            "left": 2,
                                                                            "right": 3,
                                                                            "level": 1,
                                                                            "position": 0,
                                                                            "translations": [],
                                                                            "images": [],
                                                                            "_links": {
                                                                                "self": {
                                                                                    "href": "/api/v1/taxons/mugs"
                                                                                }
                                                                            }
                                                                        },
                                                                        {
                                                                            "name": "Stickers",
                                                                            "id": 3,
                                                                            "code": "stickers",
                                                                            "children": [],
                                                                            "left": 4,
                                                                            "right": 5,
                                                                            "level": 1,
                                                                            "position": 1,
                                                                            "translations": [],
                                                                            "images": [],
                                                                            "_links": {
                                                                                "self": {
                                                                                    "href": "/api/v1/taxons/stickers"
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
                                                                            "position": 2,
                                                                            "translations": [],
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
                                                                            "name": "Category",
                                                                            "slug": "category",
                                                                            "description": "Soluta qui iusto ex quo. Aut qui ad incidunt voluptatem repellendus quaerat illum. Eos ut quas molestias nihil. Veritatis aspernatur dicta ipsa blanditiis."
                                                                        }
                                                                    },
                                                                    "images": [],
                                                                    "_links": {
                                                                        "self": {
                                                                            "href": "/api/v1/taxons/category"
                                                                        }
                                                                    }
                                                                },
                                                                "parent": {
                                                                    "name": "Category",
                                                                    "id": 1,
                                                                    "code": "category",
                                                                    "children": [
                                                                        {
                                                                            "name": "Mugs",
                                                                            "id": 2,
                                                                            "code": "mugs",
                                                                            "children": [],
                                                                            "left": 2,
                                                                            "right": 3,
                                                                            "level": 1,
                                                                            "position": 0,
                                                                            "translations": [],
                                                                            "images": [],
                                                                            "_links": {
                                                                                "self": {
                                                                                    "href": "/api/v1/taxons/mugs"
                                                                                }
                                                                            }
                                                                        },
                                                                        {
                                                                            "name": "Stickers",
                                                                            "id": 3,
                                                                            "code": "stickers",
                                                                            "children": [],
                                                                            "left": 4,
                                                                            "right": 5,
                                                                            "level": 1,
                                                                            "position": 1,
                                                                            "translations": [],
                                                                            "images": [],
                                                                            "_links": {
                                                                                "self": {
                                                                                    "href": "/api/v1/taxons/stickers"
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
                                                                            "position": 2,
                                                                            "translations": [],
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
                                                                            "name": "Category",
                                                                            "slug": "category",
                                                                            "description": "Soluta qui iusto ex quo. Aut qui ad incidunt voluptatem repellendus quaerat illum. Eos ut quas molestias nihil. Veritatis aspernatur dicta ipsa blanditiis."
                                                                        }
                                                                    },
                                                                    "images": [],
                                                                    "_links": {
                                                                        "self": {
                                                                            "href": "/api/v1/taxons/category"
                                                                        }
                                                                    }
                                                                },
                                                                "children": [
                                                                    {
                                                                        "name": "Men",
                                                                        "id": 6,
                                                                        "code": "mens_t_shirts",
                                                                        "root": {
                                                                            "name": "Category",
                                                                            "id": 1,
                                                                            "code": "category",
                                                                            "children": [
                                                                                {
                                                                                    "name": "Mugs",
                                                                                    "id": 2,
                                                                                    "code": "mugs",
                                                                                    "children": [],
                                                                                    "left": 2,
                                                                                    "right": 3,
                                                                                    "level": 1,
                                                                                    "position": 0,
                                                                                    "translations": [],
                                                                                    "images": [],
                                                                                    "_links": {
                                                                                        "self": {
                                                                                            "href": "/api/v1/taxons/mugs"
                                                                                        }
                                                                                    }
                                                                                },
                                                                                {
                                                                                    "name": "Stickers",
                                                                                    "id": 3,
                                                                                    "code": "stickers",
                                                                                    "children": [],
                                                                                    "left": 4,
                                                                                    "right": 5,
                                                                                    "level": 1,
                                                                                    "position": 1,
                                                                                    "translations": [],
                                                                                    "images": [],
                                                                                    "_links": {
                                                                                        "self": {
                                                                                            "href": "/api/v1/taxons/stickers"
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
                                                                                    "position": 2,
                                                                                    "translations": [],
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
                                                                                    "name": "Category",
                                                                                    "slug": "category",
                                                                                    "description": "Soluta qui iusto ex quo. Aut qui ad incidunt voluptatem repellendus quaerat illum. Eos ut quas molestias nihil. Veritatis aspernatur dicta ipsa blanditiis."
                                                                                }
                                                                            },
                                                                            "images": [],
                                                                            "_links": {
                                                                                "self": {
                                                                                    "href": "/api/v1/taxons/category"
                                                                                }
                                                                            }
                                                                        },
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
                                                                        "name": "Women",
                                                                        "id": 7,
                                                                        "code": "womens_t_shirts",
                                                                        "root": {
                                                                            "name": "Category",
                                                                            "id": 1,
                                                                            "code": "category",
                                                                            "children": [
                                                                                {
                                                                                    "name": "Mugs",
                                                                                    "id": 2,
                                                                                    "code": "mugs",
                                                                                    "children": [],
                                                                                    "left": 2,
                                                                                    "right": 3,
                                                                                    "level": 1,
                                                                                    "position": 0,
                                                                                    "translations": [],
                                                                                    "images": [],
                                                                                    "_links": {
                                                                                        "self": {
                                                                                            "href": "/api/v1/taxons/mugs"
                                                                                        }
                                                                                    }
                                                                                },
                                                                                {
                                                                                    "name": "Stickers",
                                                                                    "id": 3,
                                                                                    "code": "stickers",
                                                                                    "children": [],
                                                                                    "left": 4,
                                                                                    "right": 5,
                                                                                    "level": 1,
                                                                                    "position": 1,
                                                                                    "translations": [],
                                                                                    "images": [],
                                                                                    "_links": {
                                                                                        "self": {
                                                                                            "href": "/api/v1/taxons/stickers"
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
                                                                                    "position": 2,
                                                                                    "translations": [],
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
                                                                                    "name": "Category",
                                                                                    "slug": "category",
                                                                                    "description": "Soluta qui iusto ex quo. Aut qui ad incidunt voluptatem repellendus quaerat illum. Eos ut quas molestias nihil. Veritatis aspernatur dicta ipsa blanditiis."
                                                                                }
                                                                            },
                                                                            "images": [],
                                                                            "_links": {
                                                                                "self": {
                                                                                    "href": "/api/v1/taxons/category"
                                                                                }
                                                                            }
                                                                        },
                                                                        "children": [],
                                                                        "left": 11,
                                                                        "right": 12,
                                                                        "level": 2,
                                                                        "position": 1,
                                                                        "translations": {
                                                                            "de": {
                                                                                "locale": "de",
                                                                                "id": 7,
                                                                                "name": "Women",
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
                                                                "position": 3,
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
                                                            "position": 5
                                                        },
                                                        {
                                                            "id": 57,
                                                            "taxon": {
                                                                "name": "Women",
                                                                "id": 7,
                                                                "code": "womens_t_shirts",
                                                                "root": {
                                                                    "name": "Category",
                                                                    "id": 1,
                                                                    "code": "category",
                                                                    "children": [
                                                                        {
                                                                            "name": "Mugs",
                                                                            "id": 2,
                                                                            "code": "mugs",
                                                                            "children": [],
                                                                            "left": 2,
                                                                            "right": 3,
                                                                            "level": 1,
                                                                            "position": 0,
                                                                            "translations": [],
                                                                            "images": [],
                                                                            "_links": {
                                                                                "self": {
                                                                                    "href": "/api/v1/taxons/mugs"
                                                                                }
                                                                            }
                                                                        },
                                                                        {
                                                                            "name": "Stickers",
                                                                            "id": 3,
                                                                            "code": "stickers",
                                                                            "children": [],
                                                                            "left": 4,
                                                                            "right": 5,
                                                                            "level": 1,
                                                                            "position": 1,
                                                                            "translations": [],
                                                                            "images": [],
                                                                            "_links": {
                                                                                "self": {
                                                                                    "href": "/api/v1/taxons/stickers"
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
                                                                            "position": 2,
                                                                            "translations": [],
                                                                            "images": [],
                                                                            "_links": {
                                                                                "self": {
                                                                                    "href": "/api/v1/taxons/books"
                                                                                }
                                                                            }
                                                                        },
                                                                        {
                                                                            "name": "T-Shirts",
                                                                            "id": 5,
                                                                            "code": "t_shirts",
                                                                            "children": [],
                                                                            "left": 8,
                                                                            "right": 13,
                                                                            "level": 1,
                                                                            "position": 3,
                                                                            "translations": [],
                                                                            "images": [],
                                                                            "_links": {
                                                                                "self": {
                                                                                    "href": "/api/v1/taxons/t_shirts"
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
                                                                            "name": "Category",
                                                                            "slug": "category",
                                                                            "description": "Soluta qui iusto ex quo. Aut qui ad incidunt voluptatem repellendus quaerat illum. Eos ut quas molestias nihil. Veritatis aspernatur dicta ipsa blanditiis."
                                                                        }
                                                                    },
                                                                    "images": [],
                                                                    "_links": {
                                                                        "self": {
                                                                            "href": "/api/v1/taxons/category"
                                                                        }
                                                                    }
                                                                },
                                                                "parent": {
                                                                    "name": "T-Shirts",
                                                                    "id": 5,
                                                                    "code": "t_shirts",
                                                                    "root": {
                                                                        "name": "Category",
                                                                        "id": 1,
                                                                        "code": "category",
                                                                        "children": [],
                                                                        "left": 1,
                                                                        "right": 14,
                                                                        "level": 0,
                                                                        "position": 0,
                                                                        "translations": [],
                                                                        "images": [],
                                                                        "_links": {
                                                                            "self": {
                                                                                "href": "/api/v1/taxons/category"
                                                                            }
                                                                        }
                                                                    },
                                                                    "parent": {
                                                                        "name": "Category",
                                                                        "id": 1,
                                                                        "code": "category",
                                                                        "children": [],
                                                                        "left": 1,
                                                                        "right": 14,
                                                                        "level": 0,
                                                                        "position": 0,
                                                                        "translations": [],
                                                                        "images": [],
                                                                        "_links": {
                                                                            "self": {
                                                                                "href": "/api/v1/taxons/category"
                                                                            }
                                                                        }
                                                                    },
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
                                                                            "translations": [],
                                                                            "images": [],
                                                                            "_links": {
                                                                                "self": {
                                                                                    "href": "/api/v1/taxons/mens_t_shirts"
                                                                                }
                                                                            }
                                                                        }
                                                                    ],
                                                                    "left": 8,
                                                                    "right": 13,
                                                                    "level": 1,
                                                                    "position": 3,
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
                                                                "children": [],
                                                                "left": 11,
                                                                "right": 12,
                                                                "level": 2,
                                                                "position": 1,
                                                                "translations": {
                                                                    "de": {
                                                                        "locale": "de",
                                                                        "id": 7,
                                                                        "name": "Women",
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
                                                            },
                                                            "position": 2
                                                        }
                                                    ],
                                                    "channels": [
                                                        {
                                                            "id": 2,
                                                            "code": "US_WEB",
                                                            "name": "US Web Store",
                                                            "hostname": "localhost",
                                                            "color": "Wheat",
                                                            "createdAt": "2018-10-16T14:20:22+02:00",
                                                            "updatedAt": "2018-10-16T14:21:04+02:00",
                                                            "enabled": true,
                                                            "taxCalculationStrategy": "order_items_based",
                                                            "_links": {
                                                                "self": {
                                                                    "href": "/api/v1/channels/US_WEB"
                                                                }
                                                            }
                                                        }
                                                    ],
                                                    "mainTaxon": {
                                                        "name": "Women",
                                                        "id": 7,
                                                        "code": "womens_t_shirts",
                                                        "root": {
                                                            "name": "Category",
                                                            "id": 1,
                                                            "code": "category",
                                                            "children": [
                                                                {
                                                                    "name": "Mugs",
                                                                    "id": 2,
                                                                    "code": "mugs",
                                                                    "children": [],
                                                                    "left": 2,
                                                                    "right": 3,
                                                                    "level": 1,
                                                                    "position": 0,
                                                                    "translations": [],
                                                                    "images": [],
                                                                    "_links": {
                                                                        "self": {
                                                                            "href": "/api/v1/taxons/mugs"
                                                                        }
                                                                    }
                                                                },
                                                                {
                                                                    "name": "Stickers",
                                                                    "id": 3,
                                                                    "code": "stickers",
                                                                    "children": [],
                                                                    "left": 4,
                                                                    "right": 5,
                                                                    "level": 1,
                                                                    "position": 1,
                                                                    "translations": [],
                                                                    "images": [],
                                                                    "_links": {
                                                                        "self": {
                                                                            "href": "/api/v1/taxons/stickers"
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
                                                                    "position": 2,
                                                                    "translations": [],
                                                                    "images": [],
                                                                    "_links": {
                                                                        "self": {
                                                                            "href": "/api/v1/taxons/books"
                                                                        }
                                                                    }
                                                                },
                                                                {
                                                                    "name": "T-Shirts",
                                                                    "id": 5,
                                                                    "code": "t_shirts",
                                                                    "children": [],
                                                                    "left": 8,
                                                                    "right": 13,
                                                                    "level": 1,
                                                                    "position": 3,
                                                                    "translations": [],
                                                                    "images": [],
                                                                    "_links": {
                                                                        "self": {
                                                                            "href": "/api/v1/taxons/t_shirts"
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
                                                                    "name": "Category",
                                                                    "slug": "category",
                                                                    "description": "Soluta qui iusto ex quo. Aut qui ad incidunt voluptatem repellendus quaerat illum. Eos ut quas molestias nihil. Veritatis aspernatur dicta ipsa blanditiis."
                                                                }
                                                            },
                                                            "images": [],
                                                            "_links": {
                                                                "self": {
                                                                    "href": "/api/v1/taxons/category"
                                                                }
                                                            }
                                                        },
                                                        "parent": {
                                                            "name": "T-Shirts",
                                                            "id": 5,
                                                            "code": "t_shirts",
                                                            "root": {
                                                                "name": "Category",
                                                                "id": 1,
                                                                "code": "category",
                                                                "children": [],
                                                                "left": 1,
                                                                "right": 14,
                                                                "level": 0,
                                                                "position": 0,
                                                                "translations": [],
                                                                "images": [],
                                                                "_links": {
                                                                    "self": {
                                                                        "href": "/api/v1/taxons/category"
                                                                    }
                                                                }
                                                            },
                                                            "parent": {
                                                                "name": "Category",
                                                                "id": 1,
                                                                "code": "category",
                                                                "children": [],
                                                                "left": 1,
                                                                "right": 14,
                                                                "level": 0,
                                                                "position": 0,
                                                                "translations": [],
                                                                "images": [],
                                                                "_links": {
                                                                    "self": {
                                                                        "href": "/api/v1/taxons/category"
                                                                    }
                                                                }
                                                            },
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
                                                                    "translations": [],
                                                                    "images": [],
                                                                    "_links": {
                                                                        "self": {
                                                                            "href": "/api/v1/taxons/mens_t_shirts"
                                                                        }
                                                                    }
                                                                }
                                                            ],
                                                            "left": 8,
                                                            "right": 13,
                                                            "level": 1,
                                                            "position": 3,
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
                                                        "children": [],
                                                        "left": 11,
                                                        "right": 12,
                                                        "level": 2,
                                                        "position": 1,
                                                        "translations": {
                                                            "de": {
                                                                "locale": "de",
                                                                "id": 7,
                                                                "name": "Women",
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
                                                    },
                                                    "reviews": [],
                                                    "averageRating": 0.0,
                                                    "images": [
                                                        {
                                                            "id": 101,
                                                            "type": "main",
                                                            "path": "79/70/dff4362f54750a79718fab436163.jpeg"
                                                        },
                                                        {
                                                            "id": 102,
                                                            "type": "thumbnail",
                                                            "path": "f2/2c/c56924362ef7c8f394ff6c1cda70.jpeg"
                                                        }
                                                    ],
                                                    "_links": {
                                                        "self": {
                                                            "href": "/api/v1/products/b49a606c-b4c3-3fc9-be6a-28667bda250d"
                                                        },
                                                        "variants": {
                                                            "href": "/api/v1/products/b49a606c-b4c3-3fc9-be6a-28667bda250d/variants/"
                                                        }
                                                    }
                                                },
                                                {
                                                    "name": "T-Shirt \"quia\"",
                                                    "id": 58,
                                                    "code": "a8ad9edd-6bb6-3a1a-8e2b-c8bc08869646",
                                                    "attributes": [
                                                        {
                                                            "code": "t_shirt_brand",
                                                            "name": "T-Shirt brand",
                                                            "value": "Nike",
                                                            "type": "text",
                                                            "id": 142,
                                                            "localeCode": "de"
                                                        },
                                                        {
                                                            "code": "t_shirt_collection",
                                                            "name": "T-Shirt collection",
                                                            "value": "Sylius Summer 2007",
                                                            "type": "text",
                                                            "id": 143,
                                                            "localeCode": "de"
                                                        },
                                                        {
                                                            "code": "t_shirt_material",
                                                            "name": "T-Shirt material",
                                                            "value": "Wool",
                                                            "type": "text",
                                                            "id": 144,
                                                            "localeCode": "de"
                                                        }
                                                    ],
                                                    "options": [
                                                        {
                                                            "id": 3,
                                                            "code": "t_shirt_color",
                                                            "position": 2,
                                                            "values": [
                                                                {
                                                                    "code": "t_shirt_color_red",
                                                                    "translations": {
                                                                        "de": {
                                                                            "locale": "de",
                                                                            "id": 7,
                                                                            "value": "Red"
                                                                        }
                                                                    }
                                                                },
                                                                {
                                                                    "code": "t_shirt_color_black",
                                                                    "translations": {
                                                                        "de": {
                                                                            "locale": "de",
                                                                            "id": 8,
                                                                            "value": "Black"
                                                                        }
                                                                    }
                                                                },
                                                                {
                                                                    "code": "t_shirt_color_white",
                                                                    "translations": {
                                                                        "de": {
                                                                            "locale": "de",
                                                                            "id": 9,
                                                                            "value": "White"
                                                                        }
                                                                    }
                                                                }
                                                            ],
                                                            "translations": {
                                                                "de": {
                                                                    "locale": "de",
                                                                    "id": 3,
                                                                    "name": "T-Shirt color"
                                                                }
                                                            },
                                                            "_links": {
                                                                "self": {
                                                                    "href": "/api/v1/product-options/t_shirt_color"
                                                                }
                                                            }
                                                        },
                                                        {
                                                            "id": 4,
                                                            "code": "t_shirt_size",
                                                            "position": 3,
                                                            "values": [
                                                                {
                                                                    "code": "t_shirt_size_s",
                                                                    "translations": {
                                                                        "de": {
                                                                            "locale": "de",
                                                                            "id": 10,
                                                                            "value": "S"
                                                                        }
                                                                    }
                                                                },
                                                                {
                                                                    "code": "t_shirt_size_m",
                                                                    "translations": {
                                                                        "de": {
                                                                            "locale": "de",
                                                                            "id": 11,
                                                                            "value": "M"
                                                                        }
                                                                    }
                                                                },
                                                                {
                                                                    "code": "t_shirt_size_l",
                                                                    "translations": {
                                                                        "de": {
                                                                            "locale": "de",
                                                                            "id": 12,
                                                                            "value": "L"
                                                                        }
                                                                    }
                                                                },
                                                                {
                                                                    "code": "t_shirt_size_xl",
                                                                    "translations": {
                                                                        "de": {
                                                                            "locale": "de",
                                                                            "id": 13,
                                                                            "value": "XL"
                                                                        }
                                                                    }
                                                                },
                                                                {
                                                                    "code": "t_shirt_size_xxl",
                                                                    "translations": {
                                                                        "de": {
                                                                            "locale": "de",
                                                                            "id": 14,
                                                                            "value": "XXL"
                                                                        }
                                                                    }
                                                                }
                                                            ],
                                                            "translations": {
                                                                "de": {
                                                                    "locale": "de",
                                                                    "id": 4,
                                                                    "name": "T-Shirt size"
                                                                }
                                                            },
                                                            "_links": {
                                                                "self": {
                                                                    "href": "/api/v1/product-options/t_shirt_size"
                                                                }
                                                            }
                                                        }
                                                    ],
                                                    "associations": [],
                                                    "translations": {
                                                        "de": {
                                                            "locale": "de",
                                                            "id": 58,
                                                            "name": "T-Shirt \"quia\"",
                                                            "slug": "t-shirt-quia",
                                                            "description": "Vel qui nesciunt eos aperiam culpa perferendis. Dolores nihil ut sapiente exercitationem. Non doloremque qui excepturi est ut. Dolorum eos voluptatem ipsam explicabo.\n\nConsectetur quia illo in voluptatibus eos. Optio itaque commodi iste non consequatur maiores.\n\nFugiat eius sit autem sed dolorem aut. Quia fuga fuga unde. Quod quae aut dolorem necessitatibus autem maxime. Quasi maiores veniam odio in.",
                                                            "shortDescription": "Distinctio iure itaque nam adipisci debitis nobis pariatur. Voluptas dolores a accusamus tenetur dicta soluta quia. Maxime sint minus et neque placeat deleniti. Non voluptas modi nisi nisi."
                                                        }
                                                    },
                                                    "productTaxons": [
                                                        {
                                                            "id": 70,
                                                            "taxon": {
                                                                "name": "T-Shirts",
                                                                "id": 5,
                                                                "code": "t_shirts",
                                                                "root": {
                                                                    "name": "Category",
                                                                    "id": 1,
                                                                    "code": "category",
                                                                    "children": [
                                                                        {
                                                                            "name": "Mugs",
                                                                            "id": 2,
                                                                            "code": "mugs",
                                                                            "children": [],
                                                                            "left": 2,
                                                                            "right": 3,
                                                                            "level": 1,
                                                                            "position": 0,
                                                                            "translations": [],
                                                                            "images": [],
                                                                            "_links": {
                                                                                "self": {
                                                                                    "href": "/api/v1/taxons/mugs"
                                                                                }
                                                                            }
                                                                        },
                                                                        {
                                                                            "name": "Stickers",
                                                                            "id": 3,
                                                                            "code": "stickers",
                                                                            "children": [],
                                                                            "left": 4,
                                                                            "right": 5,
                                                                            "level": 1,
                                                                            "position": 1,
                                                                            "translations": [],
                                                                            "images": [],
                                                                            "_links": {
                                                                                "self": {
                                                                                    "href": "/api/v1/taxons/stickers"
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
                                                                            "position": 2,
                                                                            "translations": [],
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
                                                                            "name": "Category",
                                                                            "slug": "category",
                                                                            "description": "Soluta qui iusto ex quo. Aut qui ad incidunt voluptatem repellendus quaerat illum. Eos ut quas molestias nihil. Veritatis aspernatur dicta ipsa blanditiis."
                                                                        }
                                                                    },
                                                                    "images": [],
                                                                    "_links": {
                                                                        "self": {
                                                                            "href": "/api/v1/taxons/category"
                                                                        }
                                                                    }
                                                                },
                                                                "parent": {
                                                                    "name": "Category",
                                                                    "id": 1,
                                                                    "code": "category",
                                                                    "children": [
                                                                        {
                                                                            "name": "Mugs",
                                                                            "id": 2,
                                                                            "code": "mugs",
                                                                            "children": [],
                                                                            "left": 2,
                                                                            "right": 3,
                                                                            "level": 1,
                                                                            "position": 0,
                                                                            "translations": [],
                                                                            "images": [],
                                                                            "_links": {
                                                                                "self": {
                                                                                    "href": "/api/v1/taxons/mugs"
                                                                                }
                                                                            }
                                                                        },
                                                                        {
                                                                            "name": "Stickers",
                                                                            "id": 3,
                                                                            "code": "stickers",
                                                                            "children": [],
                                                                            "left": 4,
                                                                            "right": 5,
                                                                            "level": 1,
                                                                            "position": 1,
                                                                            "translations": [],
                                                                            "images": [],
                                                                            "_links": {
                                                                                "self": {
                                                                                    "href": "/api/v1/taxons/stickers"
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
                                                                            "position": 2,
                                                                            "translations": [],
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
                                                                            "name": "Category",
                                                                            "slug": "category",
                                                                            "description": "Soluta qui iusto ex quo. Aut qui ad incidunt voluptatem repellendus quaerat illum. Eos ut quas molestias nihil. Veritatis aspernatur dicta ipsa blanditiis."
                                                                        }
                                                                    },
                                                                    "images": [],
                                                                    "_links": {
                                                                        "self": {
                                                                            "href": "/api/v1/taxons/category"
                                                                        }
                                                                    }
                                                                },
                                                                "children": [
                                                                    {
                                                                        "name": "Men",
                                                                        "id": 6,
                                                                        "code": "mens_t_shirts",
                                                                        "root": {
                                                                            "name": "Category",
                                                                            "id": 1,
                                                                            "code": "category",
                                                                            "children": [
                                                                                {
                                                                                    "name": "Mugs",
                                                                                    "id": 2,
                                                                                    "code": "mugs",
                                                                                    "children": [],
                                                                                    "left": 2,
                                                                                    "right": 3,
                                                                                    "level": 1,
                                                                                    "position": 0,
                                                                                    "translations": [],
                                                                                    "images": [],
                                                                                    "_links": {
                                                                                        "self": {
                                                                                            "href": "/api/v1/taxons/mugs"
                                                                                        }
                                                                                    }
                                                                                },
                                                                                {
                                                                                    "name": "Stickers",
                                                                                    "id": 3,
                                                                                    "code": "stickers",
                                                                                    "children": [],
                                                                                    "left": 4,
                                                                                    "right": 5,
                                                                                    "level": 1,
                                                                                    "position": 1,
                                                                                    "translations": [],
                                                                                    "images": [],
                                                                                    "_links": {
                                                                                        "self": {
                                                                                            "href": "/api/v1/taxons/stickers"
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
                                                                                    "position": 2,
                                                                                    "translations": [],
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
                                                                                    "name": "Category",
                                                                                    "slug": "category",
                                                                                    "description": "Soluta qui iusto ex quo. Aut qui ad incidunt voluptatem repellendus quaerat illum. Eos ut quas molestias nihil. Veritatis aspernatur dicta ipsa blanditiis."
                                                                                }
                                                                            },
                                                                            "images": [],
                                                                            "_links": {
                                                                                "self": {
                                                                                    "href": "/api/v1/taxons/category"
                                                                                }
                                                                            }
                                                                        },
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
                                                                        "name": "Women",
                                                                        "id": 7,
                                                                        "code": "womens_t_shirts",
                                                                        "root": {
                                                                            "name": "Category",
                                                                            "id": 1,
                                                                            "code": "category",
                                                                            "children": [
                                                                                {
                                                                                    "name": "Mugs",
                                                                                    "id": 2,
                                                                                    "code": "mugs",
                                                                                    "children": [],
                                                                                    "left": 2,
                                                                                    "right": 3,
                                                                                    "level": 1,
                                                                                    "position": 0,
                                                                                    "translations": [],
                                                                                    "images": [],
                                                                                    "_links": {
                                                                                        "self": {
                                                                                            "href": "/api/v1/taxons/mugs"
                                                                                        }
                                                                                    }
                                                                                },
                                                                                {
                                                                                    "name": "Stickers",
                                                                                    "id": 3,
                                                                                    "code": "stickers",
                                                                                    "children": [],
                                                                                    "left": 4,
                                                                                    "right": 5,
                                                                                    "level": 1,
                                                                                    "position": 1,
                                                                                    "translations": [],
                                                                                    "images": [],
                                                                                    "_links": {
                                                                                        "self": {
                                                                                            "href": "/api/v1/taxons/stickers"
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
                                                                                    "position": 2,
                                                                                    "translations": [],
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
                                                                                    "name": "Category",
                                                                                    "slug": "category",
                                                                                    "description": "Soluta qui iusto ex quo. Aut qui ad incidunt voluptatem repellendus quaerat illum. Eos ut quas molestias nihil. Veritatis aspernatur dicta ipsa blanditiis."
                                                                                }
                                                                            },
                                                                            "images": [],
                                                                            "_links": {
                                                                                "self": {
                                                                                    "href": "/api/v1/taxons/category"
                                                                                }
                                                                            }
                                                                        },
                                                                        "children": [],
                                                                        "left": 11,
                                                                        "right": 12,
                                                                        "level": 2,
                                                                        "position": 1,
                                                                        "translations": {
                                                                            "de": {
                                                                                "locale": "de",
                                                                                "id": 7,
                                                                                "name": "Women",
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
                                                                "position": 3,
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
                                                            "position": 12
                                                        },
                                                        {
                                                            "id": 71,
                                                            "taxon": {
                                                                "name": "Women",
                                                                "id": 7,
                                                                "code": "womens_t_shirts",
                                                                "root": {
                                                                    "name": "Category",
                                                                    "id": 1,
                                                                    "code": "category",
                                                                    "children": [
                                                                        {
                                                                            "name": "Mugs",
                                                                            "id": 2,
                                                                            "code": "mugs",
                                                                            "children": [],
                                                                            "left": 2,
                                                                            "right": 3,
                                                                            "level": 1,
                                                                            "position": 0,
                                                                            "translations": [],
                                                                            "images": [],
                                                                            "_links": {
                                                                                "self": {
                                                                                    "href": "/api/v1/taxons/mugs"
                                                                                }
                                                                            }
                                                                        },
                                                                        {
                                                                            "name": "Stickers",
                                                                            "id": 3,
                                                                            "code": "stickers",
                                                                            "children": [],
                                                                            "left": 4,
                                                                            "right": 5,
                                                                            "level": 1,
                                                                            "position": 1,
                                                                            "translations": [],
                                                                            "images": [],
                                                                            "_links": {
                                                                                "self": {
                                                                                    "href": "/api/v1/taxons/stickers"
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
                                                                            "position": 2,
                                                                            "translations": [],
                                                                            "images": [],
                                                                            "_links": {
                                                                                "self": {
                                                                                    "href": "/api/v1/taxons/books"
                                                                                }
                                                                            }
                                                                        },
                                                                        {
                                                                            "name": "T-Shirts",
                                                                            "id": 5,
                                                                            "code": "t_shirts",
                                                                            "children": [],
                                                                            "left": 8,
                                                                            "right": 13,
                                                                            "level": 1,
                                                                            "position": 3,
                                                                            "translations": [],
                                                                            "images": [],
                                                                            "_links": {
                                                                                "self": {
                                                                                    "href": "/api/v1/taxons/t_shirts"
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
                                                                            "name": "Category",
                                                                            "slug": "category",
                                                                            "description": "Soluta qui iusto ex quo. Aut qui ad incidunt voluptatem repellendus quaerat illum. Eos ut quas molestias nihil. Veritatis aspernatur dicta ipsa blanditiis."
                                                                        }
                                                                    },
                                                                    "images": [],
                                                                    "_links": {
                                                                        "self": {
                                                                            "href": "/api/v1/taxons/category"
                                                                        }
                                                                    }
                                                                },
                                                                "parent": {
                                                                    "name": "T-Shirts",
                                                                    "id": 5,
                                                                    "code": "t_shirts",
                                                                    "root": {
                                                                        "name": "Category",
                                                                        "id": 1,
                                                                        "code": "category",
                                                                        "children": [],
                                                                        "left": 1,
                                                                        "right": 14,
                                                                        "level": 0,
                                                                        "position": 0,
                                                                        "translations": [],
                                                                        "images": [],
                                                                        "_links": {
                                                                            "self": {
                                                                                "href": "/api/v1/taxons/category"
                                                                            }
                                                                        }
                                                                    },
                                                                    "parent": {
                                                                        "name": "Category",
                                                                        "id": 1,
                                                                        "code": "category",
                                                                        "children": [],
                                                                        "left": 1,
                                                                        "right": 14,
                                                                        "level": 0,
                                                                        "position": 0,
                                                                        "translations": [],
                                                                        "images": [],
                                                                        "_links": {
                                                                            "self": {
                                                                                "href": "/api/v1/taxons/category"
                                                                            }
                                                                        }
                                                                    },
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
                                                                            "translations": [],
                                                                            "images": [],
                                                                            "_links": {
                                                                                "self": {
                                                                                    "href": "/api/v1/taxons/mens_t_shirts"
                                                                                }
                                                                            }
                                                                        }
                                                                    ],
                                                                    "left": 8,
                                                                    "right": 13,
                                                                    "level": 1,
                                                                    "position": 3,
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
                                                                "children": [],
                                                                "left": 11,
                                                                "right": 12,
                                                                "level": 2,
                                                                "position": 1,
                                                                "translations": {
                                                                    "de": {
                                                                        "locale": "de",
                                                                        "id": 7,
                                                                        "name": "Women",
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
                                                            },
                                                            "position": 5
                                                        }
                                                    ],
                                                    "channels": [
                                                        {
                                                            "id": 2,
                                                            "code": "US_WEB",
                                                            "name": "US Web Store",
                                                            "hostname": "localhost",
                                                            "color": "Wheat",
                                                            "createdAt": "2018-10-16T14:20:22+02:00",
                                                            "updatedAt": "2018-10-16T14:21:04+02:00",
                                                            "enabled": true,
                                                            "taxCalculationStrategy": "order_items_based",
                                                            "_links": {
                                                                "self": {
                                                                    "href": "/api/v1/channels/US_WEB"
                                                                }
                                                            }
                                                        }
                                                    ],
                                                    "mainTaxon": {
                                                        "name": "Women",
                                                        "id": 7,
                                                        "code": "womens_t_shirts",
                                                        "root": {
                                                            "name": "Category",
                                                            "id": 1,
                                                            "code": "category",
                                                            "children": [
                                                                {
                                                                    "name": "Mugs",
                                                                    "id": 2,
                                                                    "code": "mugs",
                                                                    "children": [],
                                                                    "left": 2,
                                                                    "right": 3,
                                                                    "level": 1,
                                                                    "position": 0,
                                                                    "translations": [],
                                                                    "images": [],
                                                                    "_links": {
                                                                        "self": {
                                                                            "href": "/api/v1/taxons/mugs"
                                                                        }
                                                                    }
                                                                },
                                                                {
                                                                    "name": "Stickers",
                                                                    "id": 3,
                                                                    "code": "stickers",
                                                                    "children": [],
                                                                    "left": 4,
                                                                    "right": 5,
                                                                    "level": 1,
                                                                    "position": 1,
                                                                    "translations": [],
                                                                    "images": [],
                                                                    "_links": {
                                                                        "self": {
                                                                            "href": "/api/v1/taxons/stickers"
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
                                                                    "position": 2,
                                                                    "translations": [],
                                                                    "images": [],
                                                                    "_links": {
                                                                        "self": {
                                                                            "href": "/api/v1/taxons/books"
                                                                        }
                                                                    }
                                                                },
                                                                {
                                                                    "name": "T-Shirts",
                                                                    "id": 5,
                                                                    "code": "t_shirts",
                                                                    "children": [],
                                                                    "left": 8,
                                                                    "right": 13,
                                                                    "level": 1,
                                                                    "position": 3,
                                                                    "translations": [],
                                                                    "images": [],
                                                                    "_links": {
                                                                        "self": {
                                                                            "href": "/api/v1/taxons/t_shirts"
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
                                                                    "name": "Category",
                                                                    "slug": "category",
                                                                    "description": "Soluta qui iusto ex quo. Aut qui ad incidunt voluptatem repellendus quaerat illum. Eos ut quas molestias nihil. Veritatis aspernatur dicta ipsa blanditiis."
                                                                }
                                                            },
                                                            "images": [],
                                                            "_links": {
                                                                "self": {
                                                                    "href": "/api/v1/taxons/category"
                                                                }
                                                            }
                                                        },
                                                        "parent": {
                                                            "name": "T-Shirts",
                                                            "id": 5,
                                                            "code": "t_shirts",
                                                            "root": {
                                                                "name": "Category",
                                                                "id": 1,
                                                                "code": "category",
                                                                "children": [],
                                                                "left": 1,
                                                                "right": 14,
                                                                "level": 0,
                                                                "position": 0,
                                                                "translations": [],
                                                                "images": [],
                                                                "_links": {
                                                                    "self": {
                                                                        "href": "/api/v1/taxons/category"
                                                                    }
                                                                }
                                                            },
                                                            "parent": {
                                                                "name": "Category",
                                                                "id": 1,
                                                                "code": "category",
                                                                "children": [],
                                                                "left": 1,
                                                                "right": 14,
                                                                "level": 0,
                                                                "position": 0,
                                                                "translations": [],
                                                                "images": [],
                                                                "_links": {
                                                                    "self": {
                                                                        "href": "/api/v1/taxons/category"
                                                                    }
                                                                }
                                                            },
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
                                                                    "translations": [],
                                                                    "images": [],
                                                                    "_links": {
                                                                        "self": {
                                                                            "href": "/api/v1/taxons/mens_t_shirts"
                                                                        }
                                                                    }
                                                                }
                                                            ],
                                                            "left": 8,
                                                            "right": 13,
                                                            "level": 1,
                                                            "position": 3,
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
                                                        "children": [],
                                                        "left": 11,
                                                        "right": 12,
                                                        "level": 2,
                                                        "position": 1,
                                                        "translations": {
                                                            "de": {
                                                                "locale": "de",
                                                                "id": 7,
                                                                "name": "Women",
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
                                                    },
                                                    "reviews": [],
                                                    "averageRating": 0.0,
                                                    "images": [
                                                        {
                                                            "id": 115,
                                                            "type": "main",
                                                            "path": "03/43/84279c16eb113fe11b492a589e0f.jpeg"
                                                        },
                                                        {
                                                            "id": 116,
                                                            "type": "thumbnail",
                                                            "path": "13/58/6488948b1a75f3159578c5c9fc7c.jpeg"
                                                        }
                                                    ],
                                                    "_links": {
                                                        "self": {
                                                            "href": "/api/v1/products/a8ad9edd-6bb6-3a1a-8e2b-c8bc08869646"
                                                        },
                                                        "variants": {
                                                            "href": "/api/v1/products/a8ad9edd-6bb6-3a1a-8e2b-c8bc08869646/variants/"
                                                        }
                                                    }
                                                },
                                                {
                                                    "name": "T-Shirt \"voluptate\"",
                                                    "id": 60,
                                                    "code": "f8ed6a6f-a908-3401-b200-45a6e2756e3c",
                                                    "attributes": [
                                                        {
                                                            "code": "t_shirt_brand",
                                                            "name": "T-Shirt brand",
                                                            "value": "JKM-476 Streetwear",
                                                            "type": "text",
                                                            "id": 148,
                                                            "localeCode": "de"
                                                        },
                                                        {
                                                            "code": "t_shirt_collection",
                                                            "name": "T-Shirt collection",
                                                            "value": "Sylius Autumn 2005",
                                                            "type": "text",
                                                            "id": 149,
                                                            "localeCode": "de"
                                                        },
                                                        {
                                                            "code": "t_shirt_material",
                                                            "name": "T-Shirt material",
                                                            "value": "Wool",
                                                            "type": "text",
                                                            "id": 150,
                                                            "localeCode": "de"
                                                        }
                                                    ],
                                                    "options": [
                                                        {
                                                            "id": 3,
                                                            "code": "t_shirt_color",
                                                            "position": 2,
                                                            "values": [
                                                                {
                                                                    "code": "t_shirt_color_red",
                                                                    "translations": {
                                                                        "de": {
                                                                            "locale": "de",
                                                                            "id": 7,
                                                                            "value": "Red"
                                                                        }
                                                                    }
                                                                },
                                                                {
                                                                    "code": "t_shirt_color_black",
                                                                    "translations": {
                                                                        "de": {
                                                                            "locale": "de",
                                                                            "id": 8,
                                                                            "value": "Black"
                                                                        }
                                                                    }
                                                                },
                                                                {
                                                                    "code": "t_shirt_color_white",
                                                                    "translations": {
                                                                        "de": {
                                                                            "locale": "de",
                                                                            "id": 9,
                                                                            "value": "White"
                                                                        }
                                                                    }
                                                                }
                                                            ],
                                                            "translations": {
                                                                "de": {
                                                                    "locale": "de",
                                                                    "id": 3,
                                                                    "name": "T-Shirt color"
                                                                }
                                                            },
                                                            "_links": {
                                                                "self": {
                                                                    "href": "/api/v1/product-options/t_shirt_color"
                                                                }
                                                            }
                                                        },
                                                        {
                                                            "id": 4,
                                                            "code": "t_shirt_size",
                                                            "position": 3,
                                                            "values": [
                                                                {
                                                                    "code": "t_shirt_size_s",
                                                                    "translations": {
                                                                        "de": {
                                                                            "locale": "de",
                                                                            "id": 10,
                                                                            "value": "S"
                                                                        }
                                                                    }
                                                                },
                                                                {
                                                                    "code": "t_shirt_size_m",
                                                                    "translations": {
                                                                        "de": {
                                                                            "locale": "de",
                                                                            "id": 11,
                                                                            "value": "M"
                                                                        }
                                                                    }
                                                                },
                                                                {
                                                                    "code": "t_shirt_size_l",
                                                                    "translations": {
                                                                        "de": {
                                                                            "locale": "de",
                                                                            "id": 12,
                                                                            "value": "L"
                                                                        }
                                                                    }
                                                                },
                                                                {
                                                                    "code": "t_shirt_size_xl",
                                                                    "translations": {
                                                                        "de": {
                                                                            "locale": "de",
                                                                            "id": 13,
                                                                            "value": "XL"
                                                                        }
                                                                    }
                                                                },
                                                                {
                                                                    "code": "t_shirt_size_xxl",
                                                                    "translations": {
                                                                        "de": {
                                                                            "locale": "de",
                                                                            "id": 14,
                                                                            "value": "XXL"
                                                                        }
                                                                    }
                                                                }
                                                            ],
                                                            "translations": {
                                                                "de": {
                                                                    "locale": "de",
                                                                    "id": 4,
                                                                    "name": "T-Shirt size"
                                                                }
                                                            },
                                                            "_links": {
                                                                "self": {
                                                                    "href": "/api/v1/product-options/t_shirt_size"
                                                                }
                                                            }
                                                        }
                                                    ],
                                                    "associations": [],
                                                    "translations": {
                                                        "de": {
                                                            "locale": "de",
                                                            "id": 60,
                                                            "name": "T-Shirt \"voluptate\"",
                                                            "slug": "t-shirt-voluptate",
                                                            "description": "Dolores placeat non qui tenetur totam corrupti. Officiis totam sunt tempore repellendus officiis. Modi laboriosam ex ut ratione praesentium eum.\n\nMolestias atque quae voluptatem quas. Officiis rerum sapiente vero praesentium. Natus sed consequatur saepe aut.\n\nArchitecto libero dolore distinctio qui totam placeat. Error facere iste et. Similique dolorem dolorum molestias est. Aut officia consectetur a voluptatum.",
                                                            "shortDescription": "Enim quia quos a quaerat illo impedit minima. Mollitia consectetur consequatur nobis ut similique nobis. Magnam dolores perspiciatis deserunt voluptas fuga commodi. Numquam laboriosam molestiae et reprehenderit vel neque."
                                                        }
                                                    },
                                                    "productTaxons": [
                                                        {
                                                            "id": 74,
                                                            "taxon": {
                                                                "name": "T-Shirts",
                                                                "id": 5,
                                                                "code": "t_shirts",
                                                                "root": {
                                                                    "name": "Category",
                                                                    "id": 1,
                                                                    "code": "category",
                                                                    "children": [
                                                                        {
                                                                            "name": "Mugs",
                                                                            "id": 2,
                                                                            "code": "mugs",
                                                                            "children": [],
                                                                            "left": 2,
                                                                            "right": 3,
                                                                            "level": 1,
                                                                            "position": 0,
                                                                            "translations": [],
                                                                            "images": [],
                                                                            "_links": {
                                                                                "self": {
                                                                                    "href": "/api/v1/taxons/mugs"
                                                                                }
                                                                            }
                                                                        },
                                                                        {
                                                                            "name": "Stickers",
                                                                            "id": 3,
                                                                            "code": "stickers",
                                                                            "children": [],
                                                                            "left": 4,
                                                                            "right": 5,
                                                                            "level": 1,
                                                                            "position": 1,
                                                                            "translations": [],
                                                                            "images": [],
                                                                            "_links": {
                                                                                "self": {
                                                                                    "href": "/api/v1/taxons/stickers"
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
                                                                            "position": 2,
                                                                            "translations": [],
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
                                                                            "name": "Category",
                                                                            "slug": "category",
                                                                            "description": "Soluta qui iusto ex quo. Aut qui ad incidunt voluptatem repellendus quaerat illum. Eos ut quas molestias nihil. Veritatis aspernatur dicta ipsa blanditiis."
                                                                        }
                                                                    },
                                                                    "images": [],
                                                                    "_links": {
                                                                        "self": {
                                                                            "href": "/api/v1/taxons/category"
                                                                        }
                                                                    }
                                                                },
                                                                "parent": {
                                                                    "name": "Category",
                                                                    "id": 1,
                                                                    "code": "category",
                                                                    "children": [
                                                                        {
                                                                            "name": "Mugs",
                                                                            "id": 2,
                                                                            "code": "mugs",
                                                                            "children": [],
                                                                            "left": 2,
                                                                            "right": 3,
                                                                            "level": 1,
                                                                            "position": 0,
                                                                            "translations": [],
                                                                            "images": [],
                                                                            "_links": {
                                                                                "self": {
                                                                                    "href": "/api/v1/taxons/mugs"
                                                                                }
                                                                            }
                                                                        },
                                                                        {
                                                                            "name": "Stickers",
                                                                            "id": 3,
                                                                            "code": "stickers",
                                                                            "children": [],
                                                                            "left": 4,
                                                                            "right": 5,
                                                                            "level": 1,
                                                                            "position": 1,
                                                                            "translations": [],
                                                                            "images": [],
                                                                            "_links": {
                                                                                "self": {
                                                                                    "href": "/api/v1/taxons/stickers"
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
                                                                            "position": 2,
                                                                            "translations": [],
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
                                                                            "name": "Category",
                                                                            "slug": "category",
                                                                            "description": "Soluta qui iusto ex quo. Aut qui ad incidunt voluptatem repellendus quaerat illum. Eos ut quas molestias nihil. Veritatis aspernatur dicta ipsa blanditiis."
                                                                        }
                                                                    },
                                                                    "images": [],
                                                                    "_links": {
                                                                        "self": {
                                                                            "href": "/api/v1/taxons/category"
                                                                        }
                                                                    }
                                                                },
                                                                "children": [
                                                                    {
                                                                        "name": "Men",
                                                                        "id": 6,
                                                                        "code": "mens_t_shirts",
                                                                        "root": {
                                                                            "name": "Category",
                                                                            "id": 1,
                                                                            "code": "category",
                                                                            "children": [
                                                                                {
                                                                                    "name": "Mugs",
                                                                                    "id": 2,
                                                                                    "code": "mugs",
                                                                                    "children": [],
                                                                                    "left": 2,
                                                                                    "right": 3,
                                                                                    "level": 1,
                                                                                    "position": 0,
                                                                                    "translations": [],
                                                                                    "images": [],
                                                                                    "_links": {
                                                                                        "self": {
                                                                                            "href": "/api/v1/taxons/mugs"
                                                                                        }
                                                                                    }
                                                                                },
                                                                                {
                                                                                    "name": "Stickers",
                                                                                    "id": 3,
                                                                                    "code": "stickers",
                                                                                    "children": [],
                                                                                    "left": 4,
                                                                                    "right": 5,
                                                                                    "level": 1,
                                                                                    "position": 1,
                                                                                    "translations": [],
                                                                                    "images": [],
                                                                                    "_links": {
                                                                                        "self": {
                                                                                            "href": "/api/v1/taxons/stickers"
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
                                                                                    "position": 2,
                                                                                    "translations": [],
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
                                                                                    "name": "Category",
                                                                                    "slug": "category",
                                                                                    "description": "Soluta qui iusto ex quo. Aut qui ad incidunt voluptatem repellendus quaerat illum. Eos ut quas molestias nihil. Veritatis aspernatur dicta ipsa blanditiis."
                                                                                }
                                                                            },
                                                                            "images": [],
                                                                            "_links": {
                                                                                "self": {
                                                                                    "href": "/api/v1/taxons/category"
                                                                                }
                                                                            }
                                                                        },
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
                                                                        "name": "Women",
                                                                        "id": 7,
                                                                        "code": "womens_t_shirts",
                                                                        "root": {
                                                                            "name": "Category",
                                                                            "id": 1,
                                                                            "code": "category",
                                                                            "children": [
                                                                                {
                                                                                    "name": "Mugs",
                                                                                    "id": 2,
                                                                                    "code": "mugs",
                                                                                    "children": [],
                                                                                    "left": 2,
                                                                                    "right": 3,
                                                                                    "level": 1,
                                                                                    "position": 0,
                                                                                    "translations": [],
                                                                                    "images": [],
                                                                                    "_links": {
                                                                                        "self": {
                                                                                            "href": "/api/v1/taxons/mugs"
                                                                                        }
                                                                                    }
                                                                                },
                                                                                {
                                                                                    "name": "Stickers",
                                                                                    "id": 3,
                                                                                    "code": "stickers",
                                                                                    "children": [],
                                                                                    "left": 4,
                                                                                    "right": 5,
                                                                                    "level": 1,
                                                                                    "position": 1,
                                                                                    "translations": [],
                                                                                    "images": [],
                                                                                    "_links": {
                                                                                        "self": {
                                                                                            "href": "/api/v1/taxons/stickers"
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
                                                                                    "position": 2,
                                                                                    "translations": [],
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
                                                                                    "name": "Category",
                                                                                    "slug": "category",
                                                                                    "description": "Soluta qui iusto ex quo. Aut qui ad incidunt voluptatem repellendus quaerat illum. Eos ut quas molestias nihil. Veritatis aspernatur dicta ipsa blanditiis."
                                                                                }
                                                                            },
                                                                            "images": [],
                                                                            "_links": {
                                                                                "self": {
                                                                                    "href": "/api/v1/taxons/category"
                                                                                }
                                                                            }
                                                                        },
                                                                        "children": [],
                                                                        "left": 11,
                                                                        "right": 12,
                                                                        "level": 2,
                                                                        "position": 1,
                                                                        "translations": {
                                                                            "de": {
                                                                                "locale": "de",
                                                                                "id": 7,
                                                                                "name": "Women",
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
                                                                "position": 3,
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
                                                            "position": 14
                                                        },
                                                        {
                                                            "id": 75,
                                                            "taxon": {
                                                                "name": "Women",
                                                                "id": 7,
                                                                "code": "womens_t_shirts",
                                                                "root": {
                                                                    "name": "Category",
                                                                    "id": 1,
                                                                    "code": "category",
                                                                    "children": [
                                                                        {
                                                                            "name": "Mugs",
                                                                            "id": 2,
                                                                            "code": "mugs",
                                                                            "children": [],
                                                                            "left": 2,
                                                                            "right": 3,
                                                                            "level": 1,
                                                                            "position": 0,
                                                                            "translations": [],
                                                                            "images": [],
                                                                            "_links": {
                                                                                "self": {
                                                                                    "href": "/api/v1/taxons/mugs"
                                                                                }
                                                                            }
                                                                        },
                                                                        {
                                                                            "name": "Stickers",
                                                                            "id": 3,
                                                                            "code": "stickers",
                                                                            "children": [],
                                                                            "left": 4,
                                                                            "right": 5,
                                                                            "level": 1,
                                                                            "position": 1,
                                                                            "translations": [],
                                                                            "images": [],
                                                                            "_links": {
                                                                                "self": {
                                                                                    "href": "/api/v1/taxons/stickers"
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
                                                                            "position": 2,
                                                                            "translations": [],
                                                                            "images": [],
                                                                            "_links": {
                                                                                "self": {
                                                                                    "href": "/api/v1/taxons/books"
                                                                                }
                                                                            }
                                                                        },
                                                                        {
                                                                            "name": "T-Shirts",
                                                                            "id": 5,
                                                                            "code": "t_shirts",
                                                                            "children": [],
                                                                            "left": 8,
                                                                            "right": 13,
                                                                            "level": 1,
                                                                            "position": 3,
                                                                            "translations": [],
                                                                            "images": [],
                                                                            "_links": {
                                                                                "self": {
                                                                                    "href": "/api/v1/taxons/t_shirts"
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
                                                                            "name": "Category",
                                                                            "slug": "category",
                                                                            "description": "Soluta qui iusto ex quo. Aut qui ad incidunt voluptatem repellendus quaerat illum. Eos ut quas molestias nihil. Veritatis aspernatur dicta ipsa blanditiis."
                                                                        }
                                                                    },
                                                                    "images": [],
                                                                    "_links": {
                                                                        "self": {
                                                                            "href": "/api/v1/taxons/category"
                                                                        }
                                                                    }
                                                                },
                                                                "parent": {
                                                                    "name": "T-Shirts",
                                                                    "id": 5,
                                                                    "code": "t_shirts",
                                                                    "root": {
                                                                        "name": "Category",
                                                                        "id": 1,
                                                                        "code": "category",
                                                                        "children": [],
                                                                        "left": 1,
                                                                        "right": 14,
                                                                        "level": 0,
                                                                        "position": 0,
                                                                        "translations": [],
                                                                        "images": [],
                                                                        "_links": {
                                                                            "self": {
                                                                                "href": "/api/v1/taxons/category"
                                                                            }
                                                                        }
                                                                    },
                                                                    "parent": {
                                                                        "name": "Category",
                                                                        "id": 1,
                                                                        "code": "category",
                                                                        "children": [],
                                                                        "left": 1,
                                                                        "right": 14,
                                                                        "level": 0,
                                                                        "position": 0,
                                                                        "translations": [],
                                                                        "images": [],
                                                                        "_links": {
                                                                            "self": {
                                                                                "href": "/api/v1/taxons/category"
                                                                            }
                                                                        }
                                                                    },
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
                                                                            "translations": [],
                                                                            "images": [],
                                                                            "_links": {
                                                                                "self": {
                                                                                    "href": "/api/v1/taxons/mens_t_shirts"
                                                                                }
                                                                            }
                                                                        }
                                                                    ],
                                                                    "left": 8,
                                                                    "right": 13,
                                                                    "level": 1,
                                                                    "position": 3,
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
                                                                "children": [],
                                                                "left": 11,
                                                                "right": 12,
                                                                "level": 2,
                                                                "position": 1,
                                                                "translations": {
                                                                    "de": {
                                                                        "locale": "de",
                                                                        "id": 7,
                                                                        "name": "Women",
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
                                                            },
                                                            "position": 6
                                                        }
                                                    ],
                                                    "channels": [
                                                        {
                                                            "id": 2,
                                                            "code": "US_WEB",
                                                            "name": "US Web Store",
                                                            "hostname": "localhost",
                                                            "color": "Wheat",
                                                            "createdAt": "2018-10-16T14:20:22+02:00",
                                                            "updatedAt": "2018-10-16T14:21:04+02:00",
                                                            "enabled": true,
                                                            "taxCalculationStrategy": "order_items_based",
                                                            "_links": {
                                                                "self": {
                                                                    "href": "/api/v1/channels/US_WEB"
                                                                }
                                                            }
                                                        }
                                                    ],
                                                    "mainTaxon": {
                                                        "name": "Women",
                                                        "id": 7,
                                                        "code": "womens_t_shirts",
                                                        "root": {
                                                            "name": "Category",
                                                            "id": 1,
                                                            "code": "category",
                                                            "children": [
                                                                {
                                                                    "name": "Mugs",
                                                                    "id": 2,
                                                                    "code": "mugs",
                                                                    "children": [],
                                                                    "left": 2,
                                                                    "right": 3,
                                                                    "level": 1,
                                                                    "position": 0,
                                                                    "translations": [],
                                                                    "images": [],
                                                                    "_links": {
                                                                        "self": {
                                                                            "href": "/api/v1/taxons/mugs"
                                                                        }
                                                                    }
                                                                },
                                                                {
                                                                    "name": "Stickers",
                                                                    "id": 3,
                                                                    "code": "stickers",
                                                                    "children": [],
                                                                    "left": 4,
                                                                    "right": 5,
                                                                    "level": 1,
                                                                    "position": 1,
                                                                    "translations": [],
                                                                    "images": [],
                                                                    "_links": {
                                                                        "self": {
                                                                            "href": "/api/v1/taxons/stickers"
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
                                                                    "position": 2,
                                                                    "translations": [],
                                                                    "images": [],
                                                                    "_links": {
                                                                        "self": {
                                                                            "href": "/api/v1/taxons/books"
                                                                        }
                                                                    }
                                                                },
                                                                {
                                                                    "name": "T-Shirts",
                                                                    "id": 5,
                                                                    "code": "t_shirts",
                                                                    "children": [],
                                                                    "left": 8,
                                                                    "right": 13,
                                                                    "level": 1,
                                                                    "position": 3,
                                                                    "translations": [],
                                                                    "images": [],
                                                                    "_links": {
                                                                        "self": {
                                                                            "href": "/api/v1/taxons/t_shirts"
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
                                                                    "name": "Category",
                                                                    "slug": "category",
                                                                    "description": "Soluta qui iusto ex quo. Aut qui ad incidunt voluptatem repellendus quaerat illum. Eos ut quas molestias nihil. Veritatis aspernatur dicta ipsa blanditiis."
                                                                }
                                                            },
                                                            "images": [],
                                                            "_links": {
                                                                "self": {
                                                                    "href": "/api/v1/taxons/category"
                                                                }
                                                            }
                                                        },
                                                        "parent": {
                                                            "name": "T-Shirts",
                                                            "id": 5,
                                                            "code": "t_shirts",
                                                            "root": {
                                                                "name": "Category",
                                                                "id": 1,
                                                                "code": "category",
                                                                "children": [],
                                                                "left": 1,
                                                                "right": 14,
                                                                "level": 0,
                                                                "position": 0,
                                                                "translations": [],
                                                                "images": [],
                                                                "_links": {
                                                                    "self": {
                                                                        "href": "/api/v1/taxons/category"
                                                                    }
                                                                }
                                                            },
                                                            "parent": {
                                                                "name": "Category",
                                                                "id": 1,
                                                                "code": "category",
                                                                "children": [],
                                                                "left": 1,
                                                                "right": 14,
                                                                "level": 0,
                                                                "position": 0,
                                                                "translations": [],
                                                                "images": [],
                                                                "_links": {
                                                                    "self": {
                                                                        "href": "/api/v1/taxons/category"
                                                                    }
                                                                }
                                                            },
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
                                                                    "translations": [],
                                                                    "images": [],
                                                                    "_links": {
                                                                        "self": {
                                                                            "href": "/api/v1/taxons/mens_t_shirts"
                                                                        }
                                                                    }
                                                                }
                                                            ],
                                                            "left": 8,
                                                            "right": 13,
                                                            "level": 1,
                                                            "position": 3,
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
                                                        "children": [],
                                                        "left": 11,
                                                        "right": 12,
                                                        "level": 2,
                                                        "position": 1,
                                                        "translations": {
                                                            "de": {
                                                                "locale": "de",
                                                                "id": 7,
                                                                "name": "Women",
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
                                                    },
                                                    "reviews": [],
                                                    "averageRating": 0.0,
                                                    "images": [
                                                        {
                                                            "id": 119,
                                                            "type": "main",
                                                            "path": "13/c7/0c2969778bc24385ad7d8bacdbab.jpeg"
                                                        },
                                                        {
                                                            "id": 120,
                                                            "type": "thumbnail",
                                                            "path": "fe/ca/8dd81fd04d5f01bfda776263fb9d.jpeg"
                                                        }
                                                    ],
                                                    "_links": {
                                                        "self": {
                                                            "href": "/api/v1/products/f8ed6a6f-a908-3401-b200-45a6e2756e3c"
                                                        },
                                                        "variants": {
                                                            "href": "/api/v1/products/f8ed6a6f-a908-3401-b200-45a6e2756e3c/variants/"
                                                        }
                                                    }
                                                }
                                            ]
                                        }
                                    ],
                                    "translations": {
                                        "de": {
                                            "locale": "de",
                                            "id": 50,
                                            "name": "T-Shirt \"cumque\"",
                                            "slug": "t-shirt-cumque",
                                            "description": "Quis laborum ex voluptate quidem omnis quas minus. Aliquam praesentium voluptatibus eligendi ut molestiae. Omnis veniam distinctio molestias alias officia ut.\n\nDolor ea enim voluptates aliquid deleniti. Aut assumenda cumque nihil placeat aut sed quam. Nihil qui nisi dolorem eius aliquid veniam provident in. Tempora maxime provident laboriosam pariatur.\n\nAb nihil et eos quae. Aspernatur possimus quidem ullam explicabo ea doloremque esse. Ipsam suscipit quia cum totam.",
                                            "shortDescription": "Quod ab consequatur perspiciatis atque id saepe quaerat. Non sunt ut culpa unde quo. Ipsum tempora necessitatibus quia odio illum. Eum officia sed et sapiente quam."
                                        }
                                    },
                                    "productTaxons": [
                                        {
                                            "id": 54,
                                            "taxon": {
                                                "name": "T-Shirts",
                                                "id": 5,
                                                "code": "t_shirts",
                                                "root": {
                                                    "name": "Category",
                                                    "id": 1,
                                                    "code": "category",
                                                    "children": [
                                                        {
                                                            "name": "Mugs",
                                                            "id": 2,
                                                            "code": "mugs",
                                                            "children": [],
                                                            "left": 2,
                                                            "right": 3,
                                                            "level": 1,
                                                            "position": 0,
                                                            "translations": [],
                                                            "images": [],
                                                            "_links": {
                                                                "self": {
                                                                    "href": "/api/v1/taxons/mugs"
                                                                }
                                                            }
                                                        },
                                                        {
                                                            "name": "Stickers",
                                                            "id": 3,
                                                            "code": "stickers",
                                                            "children": [],
                                                            "left": 4,
                                                            "right": 5,
                                                            "level": 1,
                                                            "position": 1,
                                                            "translations": [],
                                                            "images": [],
                                                            "_links": {
                                                                "self": {
                                                                    "href": "/api/v1/taxons/stickers"
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
                                                            "position": 2,
                                                            "translations": [],
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
                                                            "name": "Category",
                                                            "slug": "category",
                                                            "description": "Soluta qui iusto ex quo. Aut qui ad incidunt voluptatem repellendus quaerat illum. Eos ut quas molestias nihil. Veritatis aspernatur dicta ipsa blanditiis."
                                                        }
                                                    },
                                                    "images": [],
                                                    "_links": {
                                                        "self": {
                                                            "href": "/api/v1/taxons/category"
                                                        }
                                                    }
                                                },
                                                "parent": {
                                                    "name": "Category",
                                                    "id": 1,
                                                    "code": "category",
                                                    "children": [
                                                        {
                                                            "name": "Mugs",
                                                            "id": 2,
                                                            "code": "mugs",
                                                            "children": [],
                                                            "left": 2,
                                                            "right": 3,
                                                            "level": 1,
                                                            "position": 0,
                                                            "translations": [],
                                                            "images": [],
                                                            "_links": {
                                                                "self": {
                                                                    "href": "/api/v1/taxons/mugs"
                                                                }
                                                            }
                                                        },
                                                        {
                                                            "name": "Stickers",
                                                            "id": 3,
                                                            "code": "stickers",
                                                            "children": [],
                                                            "left": 4,
                                                            "right": 5,
                                                            "level": 1,
                                                            "position": 1,
                                                            "translations": [],
                                                            "images": [],
                                                            "_links": {
                                                                "self": {
                                                                    "href": "/api/v1/taxons/stickers"
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
                                                            "position": 2,
                                                            "translations": [],
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
                                                            "name": "Category",
                                                            "slug": "category",
                                                            "description": "Soluta qui iusto ex quo. Aut qui ad incidunt voluptatem repellendus quaerat illum. Eos ut quas molestias nihil. Veritatis aspernatur dicta ipsa blanditiis."
                                                        }
                                                    },
                                                    "images": [],
                                                    "_links": {
                                                        "self": {
                                                            "href": "/api/v1/taxons/category"
                                                        }
                                                    }
                                                },
                                                "children": [
                                                    {
                                                        "name": "Men",
                                                        "id": 6,
                                                        "code": "mens_t_shirts",
                                                        "root": {
                                                            "name": "Category",
                                                            "id": 1,
                                                            "code": "category",
                                                            "children": [
                                                                {
                                                                    "name": "Mugs",
                                                                    "id": 2,
                                                                    "code": "mugs",
                                                                    "children": [],
                                                                    "left": 2,
                                                                    "right": 3,
                                                                    "level": 1,
                                                                    "position": 0,
                                                                    "translations": [],
                                                                    "images": [],
                                                                    "_links": {
                                                                        "self": {
                                                                            "href": "/api/v1/taxons/mugs"
                                                                        }
                                                                    }
                                                                },
                                                                {
                                                                    "name": "Stickers",
                                                                    "id": 3,
                                                                    "code": "stickers",
                                                                    "children": [],
                                                                    "left": 4,
                                                                    "right": 5,
                                                                    "level": 1,
                                                                    "position": 1,
                                                                    "translations": [],
                                                                    "images": [],
                                                                    "_links": {
                                                                        "self": {
                                                                            "href": "/api/v1/taxons/stickers"
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
                                                                    "position": 2,
                                                                    "translations": [],
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
                                                                    "name": "Category",
                                                                    "slug": "category",
                                                                    "description": "Soluta qui iusto ex quo. Aut qui ad incidunt voluptatem repellendus quaerat illum. Eos ut quas molestias nihil. Veritatis aspernatur dicta ipsa blanditiis."
                                                                }
                                                            },
                                                            "images": [],
                                                            "_links": {
                                                                "self": {
                                                                    "href": "/api/v1/taxons/category"
                                                                }
                                                            }
                                                        },
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
                                                        "name": "Women",
                                                        "id": 7,
                                                        "code": "womens_t_shirts",
                                                        "root": {
                                                            "name": "Category",
                                                            "id": 1,
                                                            "code": "category",
                                                            "children": [
                                                                {
                                                                    "name": "Mugs",
                                                                    "id": 2,
                                                                    "code": "mugs",
                                                                    "children": [],
                                                                    "left": 2,
                                                                    "right": 3,
                                                                    "level": 1,
                                                                    "position": 0,
                                                                    "translations": [],
                                                                    "images": [],
                                                                    "_links": {
                                                                        "self": {
                                                                            "href": "/api/v1/taxons/mugs"
                                                                        }
                                                                    }
                                                                },
                                                                {
                                                                    "name": "Stickers",
                                                                    "id": 3,
                                                                    "code": "stickers",
                                                                    "children": [],
                                                                    "left": 4,
                                                                    "right": 5,
                                                                    "level": 1,
                                                                    "position": 1,
                                                                    "translations": [],
                                                                    "images": [],
                                                                    "_links": {
                                                                        "self": {
                                                                            "href": "/api/v1/taxons/stickers"
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
                                                                    "position": 2,
                                                                    "translations": [],
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
                                                                    "name": "Category",
                                                                    "slug": "category",
                                                                    "description": "Soluta qui iusto ex quo. Aut qui ad incidunt voluptatem repellendus quaerat illum. Eos ut quas molestias nihil. Veritatis aspernatur dicta ipsa blanditiis."
                                                                }
                                                            },
                                                            "images": [],
                                                            "_links": {
                                                                "self": {
                                                                    "href": "/api/v1/taxons/category"
                                                                }
                                                            }
                                                        },
                                                        "children": [],
                                                        "left": 11,
                                                        "right": 12,
                                                        "level": 2,
                                                        "position": 1,
                                                        "translations": {
                                                            "de": {
                                                                "locale": "de",
                                                                "id": 7,
                                                                "name": "Women",
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
                                                "position": 3,
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
                                            "position": 4
                                        },
                                        {
                                            "id": 55,
                                            "taxon": {
                                                "name": "Women",
                                                "id": 7,
                                                "code": "womens_t_shirts",
                                                "root": {
                                                    "name": "Category",
                                                    "id": 1,
                                                    "code": "category",
                                                    "children": [
                                                        {
                                                            "name": "Mugs",
                                                            "id": 2,
                                                            "code": "mugs",
                                                            "children": [],
                                                            "left": 2,
                                                            "right": 3,
                                                            "level": 1,
                                                            "position": 0,
                                                            "translations": [],
                                                            "images": [],
                                                            "_links": {
                                                                "self": {
                                                                    "href": "/api/v1/taxons/mugs"
                                                                }
                                                            }
                                                        },
                                                        {
                                                            "name": "Stickers",
                                                            "id": 3,
                                                            "code": "stickers",
                                                            "children": [],
                                                            "left": 4,
                                                            "right": 5,
                                                            "level": 1,
                                                            "position": 1,
                                                            "translations": [],
                                                            "images": [],
                                                            "_links": {
                                                                "self": {
                                                                    "href": "/api/v1/taxons/stickers"
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
                                                            "position": 2,
                                                            "translations": [],
                                                            "images": [],
                                                            "_links": {
                                                                "self": {
                                                                    "href": "/api/v1/taxons/books"
                                                                }
                                                            }
                                                        },
                                                        {
                                                            "name": "T-Shirts",
                                                            "id": 5,
                                                            "code": "t_shirts",
                                                            "children": [],
                                                            "left": 8,
                                                            "right": 13,
                                                            "level": 1,
                                                            "position": 3,
                                                            "translations": [],
                                                            "images": [],
                                                            "_links": {
                                                                "self": {
                                                                    "href": "/api/v1/taxons/t_shirts"
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
                                                            "name": "Category",
                                                            "slug": "category",
                                                            "description": "Soluta qui iusto ex quo. Aut qui ad incidunt voluptatem repellendus quaerat illum. Eos ut quas molestias nihil. Veritatis aspernatur dicta ipsa blanditiis."
                                                        }
                                                    },
                                                    "images": [],
                                                    "_links": {
                                                        "self": {
                                                            "href": "/api/v1/taxons/category"
                                                        }
                                                    }
                                                },
                                                "parent": {
                                                    "name": "T-Shirts",
                                                    "id": 5,
                                                    "code": "t_shirts",
                                                    "root": {
                                                        "name": "Category",
                                                        "id": 1,
                                                        "code": "category",
                                                        "children": [],
                                                        "left": 1,
                                                        "right": 14,
                                                        "level": 0,
                                                        "position": 0,
                                                        "translations": [],
                                                        "images": [],
                                                        "_links": {
                                                            "self": {
                                                                "href": "/api/v1/taxons/category"
                                                            }
                                                        }
                                                    },
                                                    "parent": {
                                                        "name": "Category",
                                                        "id": 1,
                                                        "code": "category",
                                                        "children": [],
                                                        "left": 1,
                                                        "right": 14,
                                                        "level": 0,
                                                        "position": 0,
                                                        "translations": [],
                                                        "images": [],
                                                        "_links": {
                                                            "self": {
                                                                "href": "/api/v1/taxons/category"
                                                            }
                                                        }
                                                    },
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
                                                            "translations": [],
                                                            "images": [],
                                                            "_links": {
                                                                "self": {
                                                                    "href": "/api/v1/taxons/mens_t_shirts"
                                                                }
                                                            }
                                                        }
                                                    ],
                                                    "left": 8,
                                                    "right": 13,
                                                    "level": 1,
                                                    "position": 3,
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
                                                "children": [],
                                                "left": 11,
                                                "right": 12,
                                                "level": 2,
                                                "position": 1,
                                                "translations": {
                                                    "de": {
                                                        "locale": "de",
                                                        "id": 7,
                                                        "name": "Women",
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
                                            },
                                            "position": 1
                                        }
                                    ],
                                    "channels": [
                                        {
                                            "id": 2,
                                            "code": "US_WEB",
                                            "name": "US Web Store",
                                            "hostname": "localhost",
                                            "color": "Wheat",
                                            "createdAt": "2018-10-16T14:20:22+02:00",
                                            "updatedAt": "2018-10-16T14:21:04+02:00",
                                            "enabled": true,
                                            "taxCalculationStrategy": "order_items_based",
                                            "_links": {
                                                "self": {
                                                    "href": "/api/v1/channels/US_WEB"
                                                }
                                            }
                                        }
                                    ],
                                    "mainTaxon": {
                                        "name": "Women",
                                        "id": 7,
                                        "code": "womens_t_shirts",
                                        "root": {
                                            "name": "Category",
                                            "id": 1,
                                            "code": "category",
                                            "children": [
                                                {
                                                    "name": "Mugs",
                                                    "id": 2,
                                                    "code": "mugs",
                                                    "children": [],
                                                    "left": 2,
                                                    "right": 3,
                                                    "level": 1,
                                                    "position": 0,
                                                    "translations": [],
                                                    "images": [],
                                                    "_links": {
                                                        "self": {
                                                            "href": "/api/v1/taxons/mugs"
                                                        }
                                                    }
                                                },
                                                {
                                                    "name": "Stickers",
                                                    "id": 3,
                                                    "code": "stickers",
                                                    "children": [],
                                                    "left": 4,
                                                    "right": 5,
                                                    "level": 1,
                                                    "position": 1,
                                                    "translations": [],
                                                    "images": [],
                                                    "_links": {
                                                        "self": {
                                                            "href": "/api/v1/taxons/stickers"
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
                                                    "position": 2,
                                                    "translations": [],
                                                    "images": [],
                                                    "_links": {
                                                        "self": {
                                                            "href": "/api/v1/taxons/books"
                                                        }
                                                    }
                                                },
                                                {
                                                    "name": "T-Shirts",
                                                    "id": 5,
                                                    "code": "t_shirts",
                                                    "children": [],
                                                    "left": 8,
                                                    "right": 13,
                                                    "level": 1,
                                                    "position": 3,
                                                    "translations": [],
                                                    "images": [],
                                                    "_links": {
                                                        "self": {
                                                            "href": "/api/v1/taxons/t_shirts"
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
                                                    "name": "Category",
                                                    "slug": "category",
                                                    "description": "Soluta qui iusto ex quo. Aut qui ad incidunt voluptatem repellendus quaerat illum. Eos ut quas molestias nihil. Veritatis aspernatur dicta ipsa blanditiis."
                                                }
                                            },
                                            "images": [],
                                            "_links": {
                                                "self": {
                                                    "href": "/api/v1/taxons/category"
                                                }
                                            }
                                        },
                                        "parent": {
                                            "name": "T-Shirts",
                                            "id": 5,
                                            "code": "t_shirts",
                                            "root": {
                                                "name": "Category",
                                                "id": 1,
                                                "code": "category",
                                                "children": [],
                                                "left": 1,
                                                "right": 14,
                                                "level": 0,
                                                "position": 0,
                                                "translations": [],
                                                "images": [],
                                                "_links": {
                                                    "self": {
                                                        "href": "/api/v1/taxons/category"
                                                    }
                                                }
                                            },
                                            "parent": {
                                                "name": "Category",
                                                "id": 1,
                                                "code": "category",
                                                "children": [],
                                                "left": 1,
                                                "right": 14,
                                                "level": 0,
                                                "position": 0,
                                                "translations": [],
                                                "images": [],
                                                "_links": {
                                                    "self": {
                                                        "href": "/api/v1/taxons/category"
                                                    }
                                                }
                                            },
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
                                                    "translations": [],
                                                    "images": [],
                                                    "_links": {
                                                        "self": {
                                                            "href": "/api/v1/taxons/mens_t_shirts"
                                                        }
                                                    }
                                                }
                                            ],
                                            "left": 8,
                                            "right": 13,
                                            "level": 1,
                                            "position": 3,
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
                                        "children": [],
                                        "left": 11,
                                        "right": 12,
                                        "level": 2,
                                        "position": 1,
                                        "translations": {
                                            "de": {
                                                "locale": "de",
                                                "id": 7,
                                                "name": "Women",
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
                                    },
                                    "reviews": [
                                        {
                                            "id": 37,
                                            "title": "enim aliquid nobis",
                                            "rating": 5,
                                            "comment": "Consequatur magnam voluptas et et reprehenderit qui. Possimus laudantium omnis delectus. Doloremque eaque iure ipsa accusantium.",
                                            "author": {
                                                "id": 7,
                                                "email": "slang@hotmail.com",
                                                "emailCanonical": "slang@hotmail.com",
                                                "firstName": "Gonzalo",
                                                "lastName": "O\'Reilly",
                                                "gender": "u",
                                                "group": {
                                                    "id": 2,
                                                    "code": "wholesale",
                                                    "name": "Wholesale"
                                                },
                                                "user": {
                                                    "id": 7,
                                                    "roles": [
                                                        "ROLE_USER"
                                                    ],
                                                    "enabled": true
                                                },
                                                "_links": {
                                                    "self": {
                                                        "href": "/api/v1/customers/7"
                                                    }
                                                }
                                            },
                                            "status": "accepted",
                                            "createdAt": "2018-10-16T14:20:44+02:00",
                                            "updatedAt": "2018-10-16T14:20:44+02:00"
                                        }
                                    ],
                                    "averageRating": 5.0,
                                    "images": [
                                        {
                                            "id": 99,
                                            "type": "main",
                                            "path": "98/20/7d9f98bd365ec4eb20ea3c51631e.jpeg"
                                        },
                                        {
                                            "id": 100,
                                            "type": "thumbnail",
                                            "path": "9a/ac/0c33e49a712a52c52f557b0abc0b.jpeg"
                                        }
                                    ],
                                    "_links": {
                                        "self": {
                                            "href": "/api/v1/products/a6135868-6dd1-39a7-8b2b-ab800d6d6f8f"
                                        },
                                        "variants": {
                                            "href": "/api/v1/products/a6135868-6dd1-39a7-8b2b-ab800d6d6f8f/variants/"
                                        }
                                    }
                                },
                                "2": {
                                    "name": "T-Shirt \"voluptate\"",
                                    "id": 60,
                                    "code": "f8ed6a6f-a908-3401-b200-45a6e2756e3c",
                                    "attributes": [
                                        {
                                            "code": "t_shirt_brand",
                                            "name": "T-Shirt brand",
                                            "value": "JKM-476 Streetwear",
                                            "type": "text",
                                            "id": 148,
                                            "localeCode": "de"
                                        },
                                        {
                                            "code": "t_shirt_collection",
                                            "name": "T-Shirt collection",
                                            "value": "Sylius Autumn 2005",
                                            "type": "text",
                                            "id": 149,
                                            "localeCode": "de"
                                        },
                                        {
                                            "code": "t_shirt_material",
                                            "name": "T-Shirt material",
                                            "value": "Wool",
                                            "type": "text",
                                            "id": 150,
                                            "localeCode": "de"
                                        }
                                    ],
                                    "options": [
                                        {
                                            "id": 3,
                                            "code": "t_shirt_color",
                                            "position": 2,
                                            "values": [
                                                {
                                                    "code": "t_shirt_color_red",
                                                    "translations": {
                                                        "de": {
                                                            "locale": "de",
                                                            "id": 7,
                                                            "value": "Red"
                                                        }
                                                    }
                                                },
                                                {
                                                    "code": "t_shirt_color_black",
                                                    "translations": {
                                                        "de": {
                                                            "locale": "de",
                                                            "id": 8,
                                                            "value": "Black"
                                                        }
                                                    }
                                                },
                                                {
                                                    "code": "t_shirt_color_white",
                                                    "translations": {
                                                        "de": {
                                                            "locale": "de",
                                                            "id": 9,
                                                            "value": "White"
                                                        }
                                                    }
                                                }
                                            ],
                                            "translations": {
                                                "de": {
                                                    "locale": "de",
                                                    "id": 3,
                                                    "name": "T-Shirt color"
                                                }
                                            },
                                            "_links": {
                                                "self": {
                                                    "href": "/api/v1/product-options/t_shirt_color"
                                                }
                                            }
                                        },
                                        {
                                            "id": 4,
                                            "code": "t_shirt_size",
                                            "position": 3,
                                            "values": [
                                                {
                                                    "code": "t_shirt_size_s",
                                                    "translations": {
                                                        "de": {
                                                            "locale": "de",
                                                            "id": 10,
                                                            "value": "S"
                                                        }
                                                    }
                                                },
                                                {
                                                    "code": "t_shirt_size_m",
                                                    "translations": {
                                                        "de": {
                                                            "locale": "de",
                                                            "id": 11,
                                                            "value": "M"
                                                        }
                                                    }
                                                },
                                                {
                                                    "code": "t_shirt_size_l",
                                                    "translations": {
                                                        "de": {
                                                            "locale": "de",
                                                            "id": 12,
                                                            "value": "L"
                                                        }
                                                    }
                                                },
                                                {
                                                    "code": "t_shirt_size_xl",
                                                    "translations": {
                                                        "de": {
                                                            "locale": "de",
                                                            "id": 13,
                                                            "value": "XL"
                                                        }
                                                    }
                                                },
                                                {
                                                    "code": "t_shirt_size_xxl",
                                                    "translations": {
                                                        "de": {
                                                            "locale": "de",
                                                            "id": 14,
                                                            "value": "XXL"
                                                        }
                                                    }
                                                }
                                            ],
                                            "translations": {
                                                "de": {
                                                    "locale": "de",
                                                    "id": 4,
                                                    "name": "T-Shirt size"
                                                }
                                            },
                                            "_links": {
                                                "self": {
                                                    "href": "/api/v1/product-options/t_shirt_size"
                                                }
                                            }
                                        }
                                    ],
                                    "associations": [],
                                    "translations": {
                                        "de": {
                                            "locale": "de",
                                            "id": 60,
                                            "name": "T-Shirt \"voluptate\"",
                                            "slug": "t-shirt-voluptate",
                                            "description": "Dolores placeat non qui tenetur totam corrupti. Officiis totam sunt tempore repellendus officiis. Modi laboriosam ex ut ratione praesentium eum.\n\nMolestias atque quae voluptatem quas. Officiis rerum sapiente vero praesentium. Natus sed consequatur saepe aut.\n\nArchitecto libero dolore distinctio qui totam placeat. Error facere iste et. Similique dolorem dolorum molestias est. Aut officia consectetur a voluptatum.",
                                            "shortDescription": "Enim quia quos a quaerat illo impedit minima. Mollitia consectetur consequatur nobis ut similique nobis. Magnam dolores perspiciatis deserunt voluptas fuga commodi. Numquam laboriosam molestiae et reprehenderit vel neque."
                                        }
                                    },
                                    "productTaxons": [
                                        {
                                            "id": 74,
                                            "taxon": {
                                                "name": "T-Shirts",
                                                "id": 5,
                                                "code": "t_shirts",
                                                "root": {
                                                    "name": "Category",
                                                    "id": 1,
                                                    "code": "category",
                                                    "children": [
                                                        {
                                                            "name": "Mugs",
                                                            "id": 2,
                                                            "code": "mugs",
                                                            "children": [],
                                                            "left": 2,
                                                            "right": 3,
                                                            "level": 1,
                                                            "position": 0,
                                                            "translations": [],
                                                            "images": [],
                                                            "_links": {
                                                                "self": {
                                                                    "href": "/api/v1/taxons/mugs"
                                                                }
                                                            }
                                                        },
                                                        {
                                                            "name": "Stickers",
                                                            "id": 3,
                                                            "code": "stickers",
                                                            "children": [],
                                                            "left": 4,
                                                            "right": 5,
                                                            "level": 1,
                                                            "position": 1,
                                                            "translations": [],
                                                            "images": [],
                                                            "_links": {
                                                                "self": {
                                                                    "href": "/api/v1/taxons/stickers"
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
                                                            "position": 2,
                                                            "translations": [],
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
                                                            "name": "Category",
                                                            "slug": "category",
                                                            "description": "Soluta qui iusto ex quo. Aut qui ad incidunt voluptatem repellendus quaerat illum. Eos ut quas molestias nihil. Veritatis aspernatur dicta ipsa blanditiis."
                                                        }
                                                    },
                                                    "images": [],
                                                    "_links": {
                                                        "self": {
                                                            "href": "/api/v1/taxons/category"
                                                        }
                                                    }
                                                },
                                                "parent": {
                                                    "name": "Category",
                                                    "id": 1,
                                                    "code": "category",
                                                    "children": [
                                                        {
                                                            "name": "Mugs",
                                                            "id": 2,
                                                            "code": "mugs",
                                                            "children": [],
                                                            "left": 2,
                                                            "right": 3,
                                                            "level": 1,
                                                            "position": 0,
                                                            "translations": [],
                                                            "images": [],
                                                            "_links": {
                                                                "self": {
                                                                    "href": "/api/v1/taxons/mugs"
                                                                }
                                                            }
                                                        },
                                                        {
                                                            "name": "Stickers",
                                                            "id": 3,
                                                            "code": "stickers",
                                                            "children": [],
                                                            "left": 4,
                                                            "right": 5,
                                                            "level": 1,
                                                            "position": 1,
                                                            "translations": [],
                                                            "images": [],
                                                            "_links": {
                                                                "self": {
                                                                    "href": "/api/v1/taxons/stickers"
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
                                                            "position": 2,
                                                            "translations": [],
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
                                                            "name": "Category",
                                                            "slug": "category",
                                                            "description": "Soluta qui iusto ex quo. Aut qui ad incidunt voluptatem repellendus quaerat illum. Eos ut quas molestias nihil. Veritatis aspernatur dicta ipsa blanditiis."
                                                        }
                                                    },
                                                    "images": [],
                                                    "_links": {
                                                        "self": {
                                                            "href": "/api/v1/taxons/category"
                                                        }
                                                    }
                                                },
                                                "children": [
                                                    {
                                                        "name": "Men",
                                                        "id": 6,
                                                        "code": "mens_t_shirts",
                                                        "root": {
                                                            "name": "Category",
                                                            "id": 1,
                                                            "code": "category",
                                                            "children": [
                                                                {
                                                                    "name": "Mugs",
                                                                    "id": 2,
                                                                    "code": "mugs",
                                                                    "children": [],
                                                                    "left": 2,
                                                                    "right": 3,
                                                                    "level": 1,
                                                                    "position": 0,
                                                                    "translations": [],
                                                                    "images": [],
                                                                    "_links": {
                                                                        "self": {
                                                                            "href": "/api/v1/taxons/mugs"
                                                                        }
                                                                    }
                                                                },
                                                                {
                                                                    "name": "Stickers",
                                                                    "id": 3,
                                                                    "code": "stickers",
                                                                    "children": [],
                                                                    "left": 4,
                                                                    "right": 5,
                                                                    "level": 1,
                                                                    "position": 1,
                                                                    "translations": [],
                                                                    "images": [],
                                                                    "_links": {
                                                                        "self": {
                                                                            "href": "/api/v1/taxons/stickers"
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
                                                                    "position": 2,
                                                                    "translations": [],
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
                                                                    "name": "Category",
                                                                    "slug": "category",
                                                                    "description": "Soluta qui iusto ex quo. Aut qui ad incidunt voluptatem repellendus quaerat illum. Eos ut quas molestias nihil. Veritatis aspernatur dicta ipsa blanditiis."
                                                                }
                                                            },
                                                            "images": [],
                                                            "_links": {
                                                                "self": {
                                                                    "href": "/api/v1/taxons/category"
                                                                }
                                                            }
                                                        },
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
                                                        "name": "Women",
                                                        "id": 7,
                                                        "code": "womens_t_shirts",
                                                        "root": {
                                                            "name": "Category",
                                                            "id": 1,
                                                            "code": "category",
                                                            "children": [
                                                                {
                                                                    "name": "Mugs",
                                                                    "id": 2,
                                                                    "code": "mugs",
                                                                    "children": [],
                                                                    "left": 2,
                                                                    "right": 3,
                                                                    "level": 1,
                                                                    "position": 0,
                                                                    "translations": [],
                                                                    "images": [],
                                                                    "_links": {
                                                                        "self": {
                                                                            "href": "/api/v1/taxons/mugs"
                                                                        }
                                                                    }
                                                                },
                                                                {
                                                                    "name": "Stickers",
                                                                    "id": 3,
                                                                    "code": "stickers",
                                                                    "children": [],
                                                                    "left": 4,
                                                                    "right": 5,
                                                                    "level": 1,
                                                                    "position": 1,
                                                                    "translations": [],
                                                                    "images": [],
                                                                    "_links": {
                                                                        "self": {
                                                                            "href": "/api/v1/taxons/stickers"
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
                                                                    "position": 2,
                                                                    "translations": [],
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
                                                                    "name": "Category",
                                                                    "slug": "category",
                                                                    "description": "Soluta qui iusto ex quo. Aut qui ad incidunt voluptatem repellendus quaerat illum. Eos ut quas molestias nihil. Veritatis aspernatur dicta ipsa blanditiis."
                                                                }
                                                            },
                                                            "images": [],
                                                            "_links": {
                                                                "self": {
                                                                    "href": "/api/v1/taxons/category"
                                                                }
                                                            }
                                                        },
                                                        "children": [],
                                                        "left": 11,
                                                        "right": 12,
                                                        "level": 2,
                                                        "position": 1,
                                                        "translations": {
                                                            "de": {
                                                                "locale": "de",
                                                                "id": 7,
                                                                "name": "Women",
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
                                                "position": 3,
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
                                            "position": 14
                                        },
                                        {
                                            "id": 75,
                                            "taxon": {
                                                "name": "Women",
                                                "id": 7,
                                                "code": "womens_t_shirts",
                                                "root": {
                                                    "name": "Category",
                                                    "id": 1,
                                                    "code": "category",
                                                    "children": [
                                                        {
                                                            "name": "Mugs",
                                                            "id": 2,
                                                            "code": "mugs",
                                                            "children": [],
                                                            "left": 2,
                                                            "right": 3,
                                                            "level": 1,
                                                            "position": 0,
                                                            "translations": [],
                                                            "images": [],
                                                            "_links": {
                                                                "self": {
                                                                    "href": "/api/v1/taxons/mugs"
                                                                }
                                                            }
                                                        },
                                                        {
                                                            "name": "Stickers",
                                                            "id": 3,
                                                            "code": "stickers",
                                                            "children": [],
                                                            "left": 4,
                                                            "right": 5,
                                                            "level": 1,
                                                            "position": 1,
                                                            "translations": [],
                                                            "images": [],
                                                            "_links": {
                                                                "self": {
                                                                    "href": "/api/v1/taxons/stickers"
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
                                                            "position": 2,
                                                            "translations": [],
                                                            "images": [],
                                                            "_links": {
                                                                "self": {
                                                                    "href": "/api/v1/taxons/books"
                                                                }
                                                            }
                                                        },
                                                        {
                                                            "name": "T-Shirts",
                                                            "id": 5,
                                                            "code": "t_shirts",
                                                            "children": [],
                                                            "left": 8,
                                                            "right": 13,
                                                            "level": 1,
                                                            "position": 3,
                                                            "translations": [],
                                                            "images": [],
                                                            "_links": {
                                                                "self": {
                                                                    "href": "/api/v1/taxons/t_shirts"
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
                                                            "name": "Category",
                                                            "slug": "category",
                                                            "description": "Soluta qui iusto ex quo. Aut qui ad incidunt voluptatem repellendus quaerat illum. Eos ut quas molestias nihil. Veritatis aspernatur dicta ipsa blanditiis."
                                                        }
                                                    },
                                                    "images": [],
                                                    "_links": {
                                                        "self": {
                                                            "href": "/api/v1/taxons/category"
                                                        }
                                                    }
                                                },
                                                "parent": {
                                                    "name": "T-Shirts",
                                                    "id": 5,
                                                    "code": "t_shirts",
                                                    "root": {
                                                        "name": "Category",
                                                        "id": 1,
                                                        "code": "category",
                                                        "children": [],
                                                        "left": 1,
                                                        "right": 14,
                                                        "level": 0,
                                                        "position": 0,
                                                        "translations": [],
                                                        "images": [],
                                                        "_links": {
                                                            "self": {
                                                                "href": "/api/v1/taxons/category"
                                                            }
                                                        }
                                                    },
                                                    "parent": {
                                                        "name": "Category",
                                                        "id": 1,
                                                        "code": "category",
                                                        "children": [],
                                                        "left": 1,
                                                        "right": 14,
                                                        "level": 0,
                                                        "position": 0,
                                                        "translations": [],
                                                        "images": [],
                                                        "_links": {
                                                            "self": {
                                                                "href": "/api/v1/taxons/category"
                                                            }
                                                        }
                                                    },
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
                                                            "translations": [],
                                                            "images": [],
                                                            "_links": {
                                                                "self": {
                                                                    "href": "/api/v1/taxons/mens_t_shirts"
                                                                }
                                                            }
                                                        }
                                                    ],
                                                    "left": 8,
                                                    "right": 13,
                                                    "level": 1,
                                                    "position": 3,
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
                                                "children": [],
                                                "left": 11,
                                                "right": 12,
                                                "level": 2,
                                                "position": 1,
                                                "translations": {
                                                    "de": {
                                                        "locale": "de",
                                                        "id": 7,
                                                        "name": "Women",
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
                                            },
                                            "position": 6
                                        }
                                    ],
                                    "channels": [
                                        {
                                            "id": 2,
                                            "code": "US_WEB",
                                            "name": "US Web Store",
                                            "hostname": "localhost",
                                            "color": "Wheat",
                                            "createdAt": "2018-10-16T14:20:22+02:00",
                                            "updatedAt": "2018-10-16T14:21:04+02:00",
                                            "enabled": true,
                                            "taxCalculationStrategy": "order_items_based",
                                            "_links": {
                                                "self": {
                                                    "href": "/api/v1/channels/US_WEB"
                                                }
                                            }
                                        }
                                    ],
                                    "mainTaxon": {
                                        "name": "Women",
                                        "id": 7,
                                        "code": "womens_t_shirts",
                                        "root": {
                                            "name": "Category",
                                            "id": 1,
                                            "code": "category",
                                            "children": [
                                                {
                                                    "name": "Mugs",
                                                    "id": 2,
                                                    "code": "mugs",
                                                    "children": [],
                                                    "left": 2,
                                                    "right": 3,
                                                    "level": 1,
                                                    "position": 0,
                                                    "translations": [],
                                                    "images": [],
                                                    "_links": {
                                                        "self": {
                                                            "href": "/api/v1/taxons/mugs"
                                                        }
                                                    }
                                                },
                                                {
                                                    "name": "Stickers",
                                                    "id": 3,
                                                    "code": "stickers",
                                                    "children": [],
                                                    "left": 4,
                                                    "right": 5,
                                                    "level": 1,
                                                    "position": 1,
                                                    "translations": [],
                                                    "images": [],
                                                    "_links": {
                                                        "self": {
                                                            "href": "/api/v1/taxons/stickers"
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
                                                    "position": 2,
                                                    "translations": [],
                                                    "images": [],
                                                    "_links": {
                                                        "self": {
                                                            "href": "/api/v1/taxons/books"
                                                        }
                                                    }
                                                },
                                                {
                                                    "name": "T-Shirts",
                                                    "id": 5,
                                                    "code": "t_shirts",
                                                    "children": [],
                                                    "left": 8,
                                                    "right": 13,
                                                    "level": 1,
                                                    "position": 3,
                                                    "translations": [],
                                                    "images": [],
                                                    "_links": {
                                                        "self": {
                                                            "href": "/api/v1/taxons/t_shirts"
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
                                                    "name": "Category",
                                                    "slug": "category",
                                                    "description": "Soluta qui iusto ex quo. Aut qui ad incidunt voluptatem repellendus quaerat illum. Eos ut quas molestias nihil. Veritatis aspernatur dicta ipsa blanditiis."
                                                }
                                            },
                                            "images": [],
                                            "_links": {
                                                "self": {
                                                    "href": "/api/v1/taxons/category"
                                                }
                                            }
                                        },
                                        "parent": {
                                            "name": "T-Shirts",
                                            "id": 5,
                                            "code": "t_shirts",
                                            "root": {
                                                "name": "Category",
                                                "id": 1,
                                                "code": "category",
                                                "children": [],
                                                "left": 1,
                                                "right": 14,
                                                "level": 0,
                                                "position": 0,
                                                "translations": [],
                                                "images": [],
                                                "_links": {
                                                    "self": {
                                                        "href": "/api/v1/taxons/category"
                                                    }
                                                }
                                            },
                                            "parent": {
                                                "name": "Category",
                                                "id": 1,
                                                "code": "category",
                                                "children": [],
                                                "left": 1,
                                                "right": 14,
                                                "level": 0,
                                                "position": 0,
                                                "translations": [],
                                                "images": [],
                                                "_links": {
                                                    "self": {
                                                        "href": "/api/v1/taxons/category"
                                                    }
                                                }
                                            },
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
                                                    "translations": [],
                                                    "images": [],
                                                    "_links": {
                                                        "self": {
                                                            "href": "/api/v1/taxons/mens_t_shirts"
                                                        }
                                                    }
                                                }
                                            ],
                                            "left": 8,
                                            "right": 13,
                                            "level": 1,
                                            "position": 3,
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
                                        "children": [],
                                        "left": 11,
                                        "right": 12,
                                        "level": 2,
                                        "position": 1,
                                        "translations": {
                                            "de": {
                                                "locale": "de",
                                                "id": 7,
                                                "name": "Women",
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
                                    },
                                    "reviews": [],
                                    "averageRating": 0.0,
                                    "images": [
                                        {
                                            "id": 119,
                                            "type": "main",
                                            "path": "13/c7/0c2969778bc24385ad7d8bacdbab.jpeg"
                                        },
                                        {
                                            "id": 120,
                                            "type": "thumbnail",
                                            "path": "fe/ca/8dd81fd04d5f01bfda776263fb9d.jpeg"
                                        }
                                    ],
                                    "_links": {
                                        "self": {
                                            "href": "/api/v1/products/f8ed6a6f-a908-3401-b200-45a6e2756e3c"
                                        },
                                        "variants": {
                                            "href": "/api/v1/products/f8ed6a6f-a908-3401-b200-45a6e2756e3c/variants/"
                                        }
                                    }
                                }
                            }
                        }
                    ],
                    "translations": {
                        "de": {
                            "locale": "de",
                            "id": 49,
                            "name": "T-Shirt \"perspiciatis\"",
                            "slug": "t-shirt-perspiciatis",
                            "description": "Qui sint sequi aspernatur harum quis veritatis. Dicta ut consequuntur enim modi quaerat dolorem aut voluptatum. Et a quasi unde temporibus esse reprehenderit ratione. Rem velit perspiciatis molestias deserunt eius corrupti.\n\nOdio non quia commodi. Hic iste reiciendis facilis quia molestiae est tempora. Nisi dolorum nesciunt iure eligendi maxime ea accusamus. Id eum velit hic quibusdam repellat autem est.\n\nIn eligendi iste dolorem aperiam velit cupiditate necessitatibus. Eos quod placeat delectus itaque dolorem. Ipsa reprehenderit perspiciatis provident dignissimos. Mollitia consequatur non nobis assumenda est.",
                            "shortDescription": "Reiciendis fuga nihil inventore aut odio perspiciatis eum. Rerum adipisci fuga temporibus ratione magni. Veniam assumenda a ut minima."
                        }
                    },
                    "productTaxons": [
                        {
                            "id": 52,
                            "taxon": {
                                "name": "T-Shirts",
                                "id": 5,
                                "code": "t_shirts",
                                "root": {
                                    "name": "Category",
                                    "id": 1,
                                    "code": "category",
                                    "children": [
                                        {
                                            "name": "Mugs",
                                            "id": 2,
                                            "code": "mugs",
                                            "children": [],
                                            "left": 2,
                                            "right": 3,
                                            "level": 1,
                                            "position": 0,
                                            "translations": [],
                                            "images": [],
                                            "_links": {
                                                "self": {
                                                    "href": "/api/v1/taxons/mugs"
                                                }
                                            }
                                        },
                                        {
                                            "name": "Stickers",
                                            "id": 3,
                                            "code": "stickers",
                                            "children": [],
                                            "left": 4,
                                            "right": 5,
                                            "level": 1,
                                            "position": 1,
                                            "translations": [],
                                            "images": [],
                                            "_links": {
                                                "self": {
                                                    "href": "/api/v1/taxons/stickers"
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
                                            "position": 2,
                                            "translations": [],
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
                                            "name": "Category",
                                            "slug": "category",
                                            "description": "Soluta qui iusto ex quo. Aut qui ad incidunt voluptatem repellendus quaerat illum. Eos ut quas molestias nihil. Veritatis aspernatur dicta ipsa blanditiis."
                                        }
                                    },
                                    "images": [],
                                    "_links": {
                                        "self": {
                                            "href": "/api/v1/taxons/category"
                                        }
                                    }
                                },
                                "parent": {
                                    "name": "Category",
                                    "id": 1,
                                    "code": "category",
                                    "children": [
                                        {
                                            "name": "Mugs",
                                            "id": 2,
                                            "code": "mugs",
                                            "children": [],
                                            "left": 2,
                                            "right": 3,
                                            "level": 1,
                                            "position": 0,
                                            "translations": [],
                                            "images": [],
                                            "_links": {
                                                "self": {
                                                    "href": "/api/v1/taxons/mugs"
                                                }
                                            }
                                        },
                                        {
                                            "name": "Stickers",
                                            "id": 3,
                                            "code": "stickers",
                                            "children": [],
                                            "left": 4,
                                            "right": 5,
                                            "level": 1,
                                            "position": 1,
                                            "translations": [],
                                            "images": [],
                                            "_links": {
                                                "self": {
                                                    "href": "/api/v1/taxons/stickers"
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
                                            "position": 2,
                                            "translations": [],
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
                                            "name": "Category",
                                            "slug": "category",
                                            "description": "Soluta qui iusto ex quo. Aut qui ad incidunt voluptatem repellendus quaerat illum. Eos ut quas molestias nihil. Veritatis aspernatur dicta ipsa blanditiis."
                                        }
                                    },
                                    "images": [],
                                    "_links": {
                                        "self": {
                                            "href": "/api/v1/taxons/category"
                                        }
                                    }
                                },
                                "children": [
                                    {
                                        "name": "Men",
                                        "id": 6,
                                        "code": "mens_t_shirts",
                                        "root": {
                                            "name": "Category",
                                            "id": 1,
                                            "code": "category",
                                            "children": [
                                                {
                                                    "name": "Mugs",
                                                    "id": 2,
                                                    "code": "mugs",
                                                    "children": [],
                                                    "left": 2,
                                                    "right": 3,
                                                    "level": 1,
                                                    "position": 0,
                                                    "translations": [],
                                                    "images": [],
                                                    "_links": {
                                                        "self": {
                                                            "href": "/api/v1/taxons/mugs"
                                                        }
                                                    }
                                                },
                                                {
                                                    "name": "Stickers",
                                                    "id": 3,
                                                    "code": "stickers",
                                                    "children": [],
                                                    "left": 4,
                                                    "right": 5,
                                                    "level": 1,
                                                    "position": 1,
                                                    "translations": [],
                                                    "images": [],
                                                    "_links": {
                                                        "self": {
                                                            "href": "/api/v1/taxons/stickers"
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
                                                    "position": 2,
                                                    "translations": [],
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
                                                    "name": "Category",
                                                    "slug": "category",
                                                    "description": "Soluta qui iusto ex quo. Aut qui ad incidunt voluptatem repellendus quaerat illum. Eos ut quas molestias nihil. Veritatis aspernatur dicta ipsa blanditiis."
                                                }
                                            },
                                            "images": [],
                                            "_links": {
                                                "self": {
                                                    "href": "/api/v1/taxons/category"
                                                }
                                            }
                                        },
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
                                        "name": "Women",
                                        "id": 7,
                                        "code": "womens_t_shirts",
                                        "root": {
                                            "name": "Category",
                                            "id": 1,
                                            "code": "category",
                                            "children": [
                                                {
                                                    "name": "Mugs",
                                                    "id": 2,
                                                    "code": "mugs",
                                                    "children": [],
                                                    "left": 2,
                                                    "right": 3,
                                                    "level": 1,
                                                    "position": 0,
                                                    "translations": [],
                                                    "images": [],
                                                    "_links": {
                                                        "self": {
                                                            "href": "/api/v1/taxons/mugs"
                                                        }
                                                    }
                                                },
                                                {
                                                    "name": "Stickers",
                                                    "id": 3,
                                                    "code": "stickers",
                                                    "children": [],
                                                    "left": 4,
                                                    "right": 5,
                                                    "level": 1,
                                                    "position": 1,
                                                    "translations": [],
                                                    "images": [],
                                                    "_links": {
                                                        "self": {
                                                            "href": "/api/v1/taxons/stickers"
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
                                                    "position": 2,
                                                    "translations": [],
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
                                                    "name": "Category",
                                                    "slug": "category",
                                                    "description": "Soluta qui iusto ex quo. Aut qui ad incidunt voluptatem repellendus quaerat illum. Eos ut quas molestias nihil. Veritatis aspernatur dicta ipsa blanditiis."
                                                }
                                            },
                                            "images": [],
                                            "_links": {
                                                "self": {
                                                    "href": "/api/v1/taxons/category"
                                                }
                                            }
                                        },
                                        "children": [],
                                        "left": 11,
                                        "right": 12,
                                        "level": 2,
                                        "position": 1,
                                        "translations": {
                                            "de": {
                                                "locale": "de",
                                                "id": 7,
                                                "name": "Women",
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
                                "position": 3,
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
                            "position": 3
                        },
                        {
                            "id": 53,
                            "taxon": {
                                "name": "Women",
                                "id": 7,
                                "code": "womens_t_shirts",
                                "root": {
                                    "name": "Category",
                                    "id": 1,
                                    "code": "category",
                                    "children": [
                                        {
                                            "name": "Mugs",
                                            "id": 2,
                                            "code": "mugs",
                                            "children": [],
                                            "left": 2,
                                            "right": 3,
                                            "level": 1,
                                            "position": 0,
                                            "translations": [],
                                            "images": [],
                                            "_links": {
                                                "self": {
                                                    "href": "/api/v1/taxons/mugs"
                                                }
                                            }
                                        },
                                        {
                                            "name": "Stickers",
                                            "id": 3,
                                            "code": "stickers",
                                            "children": [],
                                            "left": 4,
                                            "right": 5,
                                            "level": 1,
                                            "position": 1,
                                            "translations": [],
                                            "images": [],
                                            "_links": {
                                                "self": {
                                                    "href": "/api/v1/taxons/stickers"
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
                                            "position": 2,
                                            "translations": [],
                                            "images": [],
                                            "_links": {
                                                "self": {
                                                    "href": "/api/v1/taxons/books"
                                                }
                                            }
                                        },
                                        {
                                            "name": "T-Shirts",
                                            "id": 5,
                                            "code": "t_shirts",
                                            "children": [],
                                            "left": 8,
                                            "right": 13,
                                            "level": 1,
                                            "position": 3,
                                            "translations": [],
                                            "images": [],
                                            "_links": {
                                                "self": {
                                                    "href": "/api/v1/taxons/t_shirts"
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
                                            "name": "Category",
                                            "slug": "category",
                                            "description": "Soluta qui iusto ex quo. Aut qui ad incidunt voluptatem repellendus quaerat illum. Eos ut quas molestias nihil. Veritatis aspernatur dicta ipsa blanditiis."
                                        }
                                    },
                                    "images": [],
                                    "_links": {
                                        "self": {
                                            "href": "/api/v1/taxons/category"
                                        }
                                    }
                                },
                                "parent": {
                                    "name": "T-Shirts",
                                    "id": 5,
                                    "code": "t_shirts",
                                    "root": {
                                        "name": "Category",
                                        "id": 1,
                                        "code": "category",
                                        "children": [],
                                        "left": 1,
                                        "right": 14,
                                        "level": 0,
                                        "position": 0,
                                        "translations": [],
                                        "images": [],
                                        "_links": {
                                            "self": {
                                                "href": "/api/v1/taxons/category"
                                            }
                                        }
                                    },
                                    "parent": {
                                        "name": "Category",
                                        "id": 1,
                                        "code": "category",
                                        "children": [],
                                        "left": 1,
                                        "right": 14,
                                        "level": 0,
                                        "position": 0,
                                        "translations": [],
                                        "images": [],
                                        "_links": {
                                            "self": {
                                                "href": "/api/v1/taxons/category"
                                            }
                                        }
                                    },
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
                                            "translations": [],
                                            "images": [],
                                            "_links": {
                                                "self": {
                                                    "href": "/api/v1/taxons/mens_t_shirts"
                                                }
                                            }
                                        }
                                    ],
                                    "left": 8,
                                    "right": 13,
                                    "level": 1,
                                    "position": 3,
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
                                "children": [],
                                "left": 11,
                                "right": 12,
                                "level": 2,
                                "position": 1,
                                "translations": {
                                    "de": {
                                        "locale": "de",
                                        "id": 7,
                                        "name": "Women",
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
                            },
                            "position": 0
                        }
                    ],
                    "channels": [
                        {
                            "id": 2,
                            "code": "US_WEB",
                            "name": "US Web Store",
                            "hostname": "localhost",
                            "color": "Wheat",
                            "createdAt": "2018-10-16T14:20:22+02:00",
                            "updatedAt": "2018-10-16T14:21:04+02:00",
                            "enabled": true,
                            "taxCalculationStrategy": "order_items_based",
                            "_links": {
                                "self": {
                                    "href": "/api/v1/channels/US_WEB"
                                }
                            }
                        }
                    ],
                    "mainTaxon": {
                        "name": "Women",
                        "id": 7,
                        "code": "womens_t_shirts",
                        "root": {
                            "name": "Category",
                            "id": 1,
                            "code": "category",
                            "children": [
                                {
                                    "name": "Mugs",
                                    "id": 2,
                                    "code": "mugs",
                                    "children": [],
                                    "left": 2,
                                    "right": 3,
                                    "level": 1,
                                    "position": 0,
                                    "translations": [],
                                    "images": [],
                                    "_links": {
                                        "self": {
                                            "href": "/api/v1/taxons/mugs"
                                        }
                                    }
                                },
                                {
                                    "name": "Stickers",
                                    "id": 3,
                                    "code": "stickers",
                                    "children": [],
                                    "left": 4,
                                    "right": 5,
                                    "level": 1,
                                    "position": 1,
                                    "translations": [],
                                    "images": [],
                                    "_links": {
                                        "self": {
                                            "href": "/api/v1/taxons/stickers"
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
                                    "position": 2,
                                    "translations": [],
                                    "images": [],
                                    "_links": {
                                        "self": {
                                            "href": "/api/v1/taxons/books"
                                        }
                                    }
                                },
                                {
                                    "name": "T-Shirts",
                                    "id": 5,
                                    "code": "t_shirts",
                                    "children": [],
                                    "left": 8,
                                    "right": 13,
                                    "level": 1,
                                    "position": 3,
                                    "translations": [],
                                    "images": [],
                                    "_links": {
                                        "self": {
                                            "href": "/api/v1/taxons/t_shirts"
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
                                    "name": "Category",
                                    "slug": "category",
                                    "description": "Soluta qui iusto ex quo. Aut qui ad incidunt voluptatem repellendus quaerat illum. Eos ut quas molestias nihil. Veritatis aspernatur dicta ipsa blanditiis."
                                }
                            },
                            "images": [],
                            "_links": {
                                "self": {
                                    "href": "/api/v1/taxons/category"
                                }
                            }
                        },
                        "parent": {
                            "name": "T-Shirts",
                            "id": 5,
                            "code": "t_shirts",
                            "root": {
                                "name": "Category",
                                "id": 1,
                                "code": "category",
                                "children": [],
                                "left": 1,
                                "right": 14,
                                "level": 0,
                                "position": 0,
                                "translations": [],
                                "images": [],
                                "_links": {
                                    "self": {
                                        "href": "/api/v1/taxons/category"
                                    }
                                }
                            },
                            "parent": {
                                "name": "Category",
                                "id": 1,
                                "code": "category",
                                "children": [],
                                "left": 1,
                                "right": 14,
                                "level": 0,
                                "position": 0,
                                "translations": [],
                                "images": [],
                                "_links": {
                                    "self": {
                                        "href": "/api/v1/taxons/category"
                                    }
                                }
                            },
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
                                    "translations": [],
                                    "images": [],
                                    "_links": {
                                        "self": {
                                            "href": "/api/v1/taxons/mens_t_shirts"
                                        }
                                    }
                                }
                            ],
                            "left": 8,
                            "right": 13,
                            "level": 1,
                            "position": 3,
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
                        "children": [],
                        "left": 11,
                        "right": 12,
                        "level": 2,
                        "position": 1,
                        "translations": {
                            "de": {
                                "locale": "de",
                                "id": 7,
                                "name": "Women",
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
                    },
                    "reviews": [
                        {
                            "id": 27,
                            "title": "sint soluta harum",
                            "rating": 3,
                            "comment": "Amet sit deleniti placeat culpa sed asperiores neque id. Aut sunt tempora esse corrupti. Praesentium aliquid earum quibusdam dolor nobis.",
                            "author": {
                                "id": 4,
                                "email": "ythompson@hotmail.com",
                                "emailCanonical": "ythompson@hotmail.com",
                                "firstName": "Nigel",
                                "lastName": "Reichel",
                                "gender": "u",
                                "group": {
                                    "id": 2,
                                    "code": "wholesale",
                                    "name": "Wholesale"
                                },
                                "user": {
                                    "id": 4,
                                    "roles": [
                                        "ROLE_USER"
                                    ],
                                    "enabled": true
                                },
                                "_links": {
                                    "self": {
                                        "href": "/api/v1/customers/4"
                                    }
                                }
                            },
                            "status": "rejected",
                            "createdAt": "2018-10-16T14:20:42+02:00",
                            "updatedAt": "2018-10-16T14:20:42+02:00"
                        }
                    ],
                    "averageRating": 0.0,
                    "images": [
                        {
                            "id": 97,
                            "type": "main",
                            "path": "98/a2/2a88c3c282b4b0970f3d41648446.jpeg"
                        },
                        {
                            "id": 98,
                            "type": "thumbnail",
                            "path": "84/24/7ed2cf2aeb9a5cd6e4266c0eb197.jpeg"
                        }
                    ],
                    "_links": {
                        "self": {
                            "href": "/api/v1/products/7b704b89-f97e-3a05-92ec-322b04724201"
                        },
                        "variants": {
                            "href": "/api/v1/products/7b704b89-f97e-3a05-92ec-322b04724201/variants/"
                        }
                    }
                },
                {
                    "name": "T-Shirt \"tempore\"",
                    "id": 51,
                    "code": "b49a606c-b4c3-3fc9-be6a-28667bda250d",
                    "attributes": [
                        {
                            "code": "t_shirt_brand",
                            "name": "T-Shirt brand",
                            "value": "Nike",
                            "type": "text",
                            "id": 121,
                            "localeCode": "de"
                        },
                        {
                            "code": "t_shirt_collection",
                            "name": "T-Shirt collection",
                            "value": "Sylius Winter 2000",
                            "type": "text",
                            "id": 122,
                            "localeCode": "de"
                        },
                        {
                            "code": "t_shirt_material",
                            "name": "T-Shirt material",
                            "value": "Centipede 10% / Wool 90%",
                            "type": "text",
                            "id": 123,
                            "localeCode": "de"
                        }
                    ],
                    "options": [
                        {
                            "id": 3,
                            "code": "t_shirt_color",
                            "position": 2,
                            "values": [
                                {
                                    "code": "t_shirt_color_red",
                                    "translations": {
                                        "de": {
                                            "locale": "de",
                                            "id": 7,
                                            "value": "Red"
                                        }
                                    }
                                },
                                {
                                    "code": "t_shirt_color_black",
                                    "translations": {
                                        "de": {
                                            "locale": "de",
                                            "id": 8,
                                            "value": "Black"
                                        }
                                    }
                                },
                                {
                                    "code": "t_shirt_color_white",
                                    "translations": {
                                        "de": {
                                            "locale": "de",
                                            "id": 9,
                                            "value": "White"
                                        }
                                    }
                                }
                            ],
                            "translations": {
                                "de": {
                                    "locale": "de",
                                    "id": 3,
                                    "name": "T-Shirt color"
                                }
                            },
                            "_links": {
                                "self": {
                                    "href": "/api/v1/product-options/t_shirt_color"
                                }
                            }
                        },
                        {
                            "id": 4,
                            "code": "t_shirt_size",
                            "position": 3,
                            "values": [
                                {
                                    "code": "t_shirt_size_s",
                                    "translations": {
                                        "de": {
                                            "locale": "de",
                                            "id": 10,
                                            "value": "S"
                                        }
                                    }
                                },
                                {
                                    "code": "t_shirt_size_m",
                                    "translations": {
                                        "de": {
                                            "locale": "de",
                                            "id": 11,
                                            "value": "M"
                                        }
                                    }
                                },
                                {
                                    "code": "t_shirt_size_l",
                                    "translations": {
                                        "de": {
                                            "locale": "de",
                                            "id": 12,
                                            "value": "L"
                                        }
                                    }
                                },
                                {
                                    "code": "t_shirt_size_xl",
                                    "translations": {
                                        "de": {
                                            "locale": "de",
                                            "id": 13,
                                            "value": "XL"
                                        }
                                    }
                                },
                                {
                                    "code": "t_shirt_size_xxl",
                                    "translations": {
                                        "de": {
                                            "locale": "de",
                                            "id": 14,
                                            "value": "XXL"
                                        }
                                    }
                                }
                            ],
                            "translations": {
                                "de": {
                                    "locale": "de",
                                    "id": 4,
                                    "name": "T-Shirt size"
                                }
                            },
                            "_links": {
                                "self": {
                                    "href": "/api/v1/product-options/t_shirt_size"
                                }
                            }
                        }
                    ],
                    "associations": [],
                    "translations": {
                        "de": {
                            "locale": "de",
                            "id": 51,
                            "name": "T-Shirt \"tempore\"",
                            "slug": "t-shirt-tempore",
                            "description": "Consequatur debitis quia ullam. Est consequatur facere officia dolor dolores et non. Praesentium quidem eos vel qui sequi autem dolore totam. Quis odio beatae blanditiis nihil tempora.\n\nTotam maxime in culpa voluptatibus ab et. Corporis beatae officia molestiae sapiente aliquid odit veritatis. Ea perferendis suscipit omnis.\n\nSed optio quis qui aut ea laborum est. Tempore ipsam dicta qui sit. Consequuntur deleniti similique debitis eos laboriosam quis. Commodi accusamus aliquid autem qui rerum ratione dolorum et.",
                            "shortDescription": "Illum velit repellendus voluptate et vero repudiandae nam. Nemo qui id eaque quia in excepturi libero."
                        }
                    },
                    "productTaxons": [
                        {
                            "id": 56,
                            "taxon": {
                                "name": "T-Shirts",
                                "id": 5,
                                "code": "t_shirts",
                                "root": {
                                    "name": "Category",
                                    "id": 1,
                                    "code": "category",
                                    "children": [
                                        {
                                            "name": "Mugs",
                                            "id": 2,
                                            "code": "mugs",
                                            "children": [],
                                            "left": 2,
                                            "right": 3,
                                            "level": 1,
                                            "position": 0,
                                            "translations": [],
                                            "images": [],
                                            "_links": {
                                                "self": {
                                                    "href": "/api/v1/taxons/mugs"
                                                }
                                            }
                                        },
                                        {
                                            "name": "Stickers",
                                            "id": 3,
                                            "code": "stickers",
                                            "children": [],
                                            "left": 4,
                                            "right": 5,
                                            "level": 1,
                                            "position": 1,
                                            "translations": [],
                                            "images": [],
                                            "_links": {
                                                "self": {
                                                    "href": "/api/v1/taxons/stickers"
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
                                            "position": 2,
                                            "translations": [],
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
                                            "name": "Category",
                                            "slug": "category",
                                            "description": "Soluta qui iusto ex quo. Aut qui ad incidunt voluptatem repellendus quaerat illum. Eos ut quas molestias nihil. Veritatis aspernatur dicta ipsa blanditiis."
                                        }
                                    },
                                    "images": [],
                                    "_links": {
                                        "self": {
                                            "href": "/api/v1/taxons/category"
                                        }
                                    }
                                },
                                "parent": {
                                    "name": "Category",
                                    "id": 1,
                                    "code": "category",
                                    "children": [
                                        {
                                            "name": "Mugs",
                                            "id": 2,
                                            "code": "mugs",
                                            "children": [],
                                            "left": 2,
                                            "right": 3,
                                            "level": 1,
                                            "position": 0,
                                            "translations": [],
                                            "images": [],
                                            "_links": {
                                                "self": {
                                                    "href": "/api/v1/taxons/mugs"
                                                }
                                            }
                                        },
                                        {
                                            "name": "Stickers",
                                            "id": 3,
                                            "code": "stickers",
                                            "children": [],
                                            "left": 4,
                                            "right": 5,
                                            "level": 1,
                                            "position": 1,
                                            "translations": [],
                                            "images": [],
                                            "_links": {
                                                "self": {
                                                    "href": "/api/v1/taxons/stickers"
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
                                            "position": 2,
                                            "translations": [],
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
                                            "name": "Category",
                                            "slug": "category",
                                            "description": "Soluta qui iusto ex quo. Aut qui ad incidunt voluptatem repellendus quaerat illum. Eos ut quas molestias nihil. Veritatis aspernatur dicta ipsa blanditiis."
                                        }
                                    },
                                    "images": [],
                                    "_links": {
                                        "self": {
                                            "href": "/api/v1/taxons/category"
                                        }
                                    }
                                },
                                "children": [
                                    {
                                        "name": "Men",
                                        "id": 6,
                                        "code": "mens_t_shirts",
                                        "root": {
                                            "name": "Category",
                                            "id": 1,
                                            "code": "category",
                                            "children": [
                                                {
                                                    "name": "Mugs",
                                                    "id": 2,
                                                    "code": "mugs",
                                                    "children": [],
                                                    "left": 2,
                                                    "right": 3,
                                                    "level": 1,
                                                    "position": 0,
                                                    "translations": [],
                                                    "images": [],
                                                    "_links": {
                                                        "self": {
                                                            "href": "/api/v1/taxons/mugs"
                                                        }
                                                    }
                                                },
                                                {
                                                    "name": "Stickers",
                                                    "id": 3,
                                                    "code": "stickers",
                                                    "children": [],
                                                    "left": 4,
                                                    "right": 5,
                                                    "level": 1,
                                                    "position": 1,
                                                    "translations": [],
                                                    "images": [],
                                                    "_links": {
                                                        "self": {
                                                            "href": "/api/v1/taxons/stickers"
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
                                                    "position": 2,
                                                    "translations": [],
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
                                                    "name": "Category",
                                                    "slug": "category",
                                                    "description": "Soluta qui iusto ex quo. Aut qui ad incidunt voluptatem repellendus quaerat illum. Eos ut quas molestias nihil. Veritatis aspernatur dicta ipsa blanditiis."
                                                }
                                            },
                                            "images": [],
                                            "_links": {
                                                "self": {
                                                    "href": "/api/v1/taxons/category"
                                                }
                                            }
                                        },
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
                                        "name": "Women",
                                        "id": 7,
                                        "code": "womens_t_shirts",
                                        "root": {
                                            "name": "Category",
                                            "id": 1,
                                            "code": "category",
                                            "children": [
                                                {
                                                    "name": "Mugs",
                                                    "id": 2,
                                                    "code": "mugs",
                                                    "children": [],
                                                    "left": 2,
                                                    "right": 3,
                                                    "level": 1,
                                                    "position": 0,
                                                    "translations": [],
                                                    "images": [],
                                                    "_links": {
                                                        "self": {
                                                            "href": "/api/v1/taxons/mugs"
                                                        }
                                                    }
                                                },
                                                {
                                                    "name": "Stickers",
                                                    "id": 3,
                                                    "code": "stickers",
                                                    "children": [],
                                                    "left": 4,
                                                    "right": 5,
                                                    "level": 1,
                                                    "position": 1,
                                                    "translations": [],
                                                    "images": [],
                                                    "_links": {
                                                        "self": {
                                                            "href": "/api/v1/taxons/stickers"
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
                                                    "position": 2,
                                                    "translations": [],
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
                                                    "name": "Category",
                                                    "slug": "category",
                                                    "description": "Soluta qui iusto ex quo. Aut qui ad incidunt voluptatem repellendus quaerat illum. Eos ut quas molestias nihil. Veritatis aspernatur dicta ipsa blanditiis."
                                                }
                                            },
                                            "images": [],
                                            "_links": {
                                                "self": {
                                                    "href": "/api/v1/taxons/category"
                                                }
                                            }
                                        },
                                        "children": [],
                                        "left": 11,
                                        "right": 12,
                                        "level": 2,
                                        "position": 1,
                                        "translations": {
                                            "de": {
                                                "locale": "de",
                                                "id": 7,
                                                "name": "Women",
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
                                "position": 3,
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
                            "position": 5
                        },
                        {
                            "id": 57,
                            "taxon": {
                                "name": "Women",
                                "id": 7,
                                "code": "womens_t_shirts",
                                "root": {
                                    "name": "Category",
                                    "id": 1,
                                    "code": "category",
                                    "children": [
                                        {
                                            "name": "Mugs",
                                            "id": 2,
                                            "code": "mugs",
                                            "children": [],
                                            "left": 2,
                                            "right": 3,
                                            "level": 1,
                                            "position": 0,
                                            "translations": [],
                                            "images": [],
                                            "_links": {
                                                "self": {
                                                    "href": "/api/v1/taxons/mugs"
                                                }
                                            }
                                        },
                                        {
                                            "name": "Stickers",
                                            "id": 3,
                                            "code": "stickers",
                                            "children": [],
                                            "left": 4,
                                            "right": 5,
                                            "level": 1,
                                            "position": 1,
                                            "translations": [],
                                            "images": [],
                                            "_links": {
                                                "self": {
                                                    "href": "/api/v1/taxons/stickers"
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
                                            "position": 2,
                                            "translations": [],
                                            "images": [],
                                            "_links": {
                                                "self": {
                                                    "href": "/api/v1/taxons/books"
                                                }
                                            }
                                        },
                                        {
                                            "name": "T-Shirts",
                                            "id": 5,
                                            "code": "t_shirts",
                                            "children": [],
                                            "left": 8,
                                            "right": 13,
                                            "level": 1,
                                            "position": 3,
                                            "translations": [],
                                            "images": [],
                                            "_links": {
                                                "self": {
                                                    "href": "/api/v1/taxons/t_shirts"
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
                                            "name": "Category",
                                            "slug": "category",
                                            "description": "Soluta qui iusto ex quo. Aut qui ad incidunt voluptatem repellendus quaerat illum. Eos ut quas molestias nihil. Veritatis aspernatur dicta ipsa blanditiis."
                                        }
                                    },
                                    "images": [],
                                    "_links": {
                                        "self": {
                                            "href": "/api/v1/taxons/category"
                                        }
                                    }
                                },
                                "parent": {
                                    "name": "T-Shirts",
                                    "id": 5,
                                    "code": "t_shirts",
                                    "root": {
                                        "name": "Category",
                                        "id": 1,
                                        "code": "category",
                                        "children": [],
                                        "left": 1,
                                        "right": 14,
                                        "level": 0,
                                        "position": 0,
                                        "translations": [],
                                        "images": [],
                                        "_links": {
                                            "self": {
                                                "href": "/api/v1/taxons/category"
                                            }
                                        }
                                    },
                                    "parent": {
                                        "name": "Category",
                                        "id": 1,
                                        "code": "category",
                                        "children": [],
                                        "left": 1,
                                        "right": 14,
                                        "level": 0,
                                        "position": 0,
                                        "translations": [],
                                        "images": [],
                                        "_links": {
                                            "self": {
                                                "href": "/api/v1/taxons/category"
                                            }
                                        }
                                    },
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
                                            "translations": [],
                                            "images": [],
                                            "_links": {
                                                "self": {
                                                    "href": "/api/v1/taxons/mens_t_shirts"
                                                }
                                            }
                                        }
                                    ],
                                    "left": 8,
                                    "right": 13,
                                    "level": 1,
                                    "position": 3,
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
                                "children": [],
                                "left": 11,
                                "right": 12,
                                "level": 2,
                                "position": 1,
                                "translations": {
                                    "de": {
                                        "locale": "de",
                                        "id": 7,
                                        "name": "Women",
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
                            },
                            "position": 2
                        }
                    ],
                    "channels": [
                        {
                            "id": 2,
                            "code": "US_WEB",
                            "name": "US Web Store",
                            "hostname": "localhost",
                            "color": "Wheat",
                            "createdAt": "2018-10-16T14:20:22+02:00",
                            "updatedAt": "2018-10-16T14:21:04+02:00",
                            "enabled": true,
                            "taxCalculationStrategy": "order_items_based",
                            "_links": {
                                "self": {
                                    "href": "/api/v1/channels/US_WEB"
                                }
                            }
                        }
                    ],
                    "mainTaxon": {
                        "name": "Women",
                        "id": 7,
                        "code": "womens_t_shirts",
                        "root": {
                            "name": "Category",
                            "id": 1,
                            "code": "category",
                            "children": [
                                {
                                    "name": "Mugs",
                                    "id": 2,
                                    "code": "mugs",
                                    "children": [],
                                    "left": 2,
                                    "right": 3,
                                    "level": 1,
                                    "position": 0,
                                    "translations": [],
                                    "images": [],
                                    "_links": {
                                        "self": {
                                            "href": "/api/v1/taxons/mugs"
                                        }
                                    }
                                },
                                {
                                    "name": "Stickers",
                                    "id": 3,
                                    "code": "stickers",
                                    "children": [],
                                    "left": 4,
                                    "right": 5,
                                    "level": 1,
                                    "position": 1,
                                    "translations": [],
                                    "images": [],
                                    "_links": {
                                        "self": {
                                            "href": "/api/v1/taxons/stickers"
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
                                    "position": 2,
                                    "translations": [],
                                    "images": [],
                                    "_links": {
                                        "self": {
                                            "href": "/api/v1/taxons/books"
                                        }
                                    }
                                },
                                {
                                    "name": "T-Shirts",
                                    "id": 5,
                                    "code": "t_shirts",
                                    "children": [],
                                    "left": 8,
                                    "right": 13,
                                    "level": 1,
                                    "position": 3,
                                    "translations": [],
                                    "images": [],
                                    "_links": {
                                        "self": {
                                            "href": "/api/v1/taxons/t_shirts"
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
                                    "name": "Category",
                                    "slug": "category",
                                    "description": "Soluta qui iusto ex quo. Aut qui ad incidunt voluptatem repellendus quaerat illum. Eos ut quas molestias nihil. Veritatis aspernatur dicta ipsa blanditiis."
                                }
                            },
                            "images": [],
                            "_links": {
                                "self": {
                                    "href": "/api/v1/taxons/category"
                                }
                            }
                        },
                        "parent": {
                            "name": "T-Shirts",
                            "id": 5,
                            "code": "t_shirts",
                            "root": {
                                "name": "Category",
                                "id": 1,
                                "code": "category",
                                "children": [],
                                "left": 1,
                                "right": 14,
                                "level": 0,
                                "position": 0,
                                "translations": [],
                                "images": [],
                                "_links": {
                                    "self": {
                                        "href": "/api/v1/taxons/category"
                                    }
                                }
                            },
                            "parent": {
                                "name": "Category",
                                "id": 1,
                                "code": "category",
                                "children": [],
                                "left": 1,
                                "right": 14,
                                "level": 0,
                                "position": 0,
                                "translations": [],
                                "images": [],
                                "_links": {
                                    "self": {
                                        "href": "/api/v1/taxons/category"
                                    }
                                }
                            },
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
                                    "translations": [],
                                    "images": [],
                                    "_links": {
                                        "self": {
                                            "href": "/api/v1/taxons/mens_t_shirts"
                                        }
                                    }
                                }
                            ],
                            "left": 8,
                            "right": 13,
                            "level": 1,
                            "position": 3,
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
                        "children": [],
                        "left": 11,
                        "right": 12,
                        "level": 2,
                        "position": 1,
                        "translations": {
                            "de": {
                                "locale": "de",
                                "id": 7,
                                "name": "Women",
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
                    },
                    "reviews": [],
                    "averageRating": 0.0,
                    "images": [
                        {
                            "id": 101,
                            "type": "main",
                            "path": "79/70/dff4362f54750a79718fab436163.jpeg"
                        },
                        {
                            "id": 102,
                            "type": "thumbnail",
                            "path": "f2/2c/c56924362ef7c8f394ff6c1cda70.jpeg"
                        }
                    ],
                    "_links": {
                        "self": {
                            "href": "/api/v1/products/b49a606c-b4c3-3fc9-be6a-28667bda250d"
                        },
                        "variants": {
                            "href": "/api/v1/products/b49a606c-b4c3-3fc9-be6a-28667bda250d/variants/"
                        }
                    }
                },
                {
                    "name": "T-Shirt \"voluptate\"",
                    "id": 60,
                    "code": "f8ed6a6f-a908-3401-b200-45a6e2756e3c",
                    "attributes": [
                        {
                            "code": "t_shirt_brand",
                            "name": "T-Shirt brand",
                            "value": "JKM-476 Streetwear",
                            "type": "text",
                            "id": 148,
                            "localeCode": "de"
                        },
                        {
                            "code": "t_shirt_collection",
                            "name": "T-Shirt collection",
                            "value": "Sylius Autumn 2005",
                            "type": "text",
                            "id": 149,
                            "localeCode": "de"
                        },
                        {
                            "code": "t_shirt_material",
                            "name": "T-Shirt material",
                            "value": "Wool",
                            "type": "text",
                            "id": 150,
                            "localeCode": "de"
                        }
                    ],
                    "options": [
                        {
                            "id": 3,
                            "code": "t_shirt_color",
                            "position": 2,
                            "values": [
                                {
                                    "code": "t_shirt_color_red",
                                    "translations": {
                                        "de": {
                                            "locale": "de",
                                            "id": 7,
                                            "value": "Red"
                                        }
                                    }
                                },
                                {
                                    "code": "t_shirt_color_black",
                                    "translations": {
                                        "de": {
                                            "locale": "de",
                                            "id": 8,
                                            "value": "Black"
                                        }
                                    }
                                },
                                {
                                    "code": "t_shirt_color_white",
                                    "translations": {
                                        "de": {
                                            "locale": "de",
                                            "id": 9,
                                            "value": "White"
                                        }
                                    }
                                }
                            ],
                            "translations": {
                                "de": {
                                    "locale": "de",
                                    "id": 3,
                                    "name": "T-Shirt color"
                                }
                            },
                            "_links": {
                                "self": {
                                    "href": "/api/v1/product-options/t_shirt_color"
                                }
                            }
                        },
                        {
                            "id": 4,
                            "code": "t_shirt_size",
                            "position": 3,
                            "values": [
                                {
                                    "code": "t_shirt_size_s",
                                    "translations": {
                                        "de": {
                                            "locale": "de",
                                            "id": 10,
                                            "value": "S"
                                        }
                                    }
                                },
                                {
                                    "code": "t_shirt_size_m",
                                    "translations": {
                                        "de": {
                                            "locale": "de",
                                            "id": 11,
                                            "value": "M"
                                        }
                                    }
                                },
                                {
                                    "code": "t_shirt_size_l",
                                    "translations": {
                                        "de": {
                                            "locale": "de",
                                            "id": 12,
                                            "value": "L"
                                        }
                                    }
                                },
                                {
                                    "code": "t_shirt_size_xl",
                                    "translations": {
                                        "de": {
                                            "locale": "de",
                                            "id": 13,
                                            "value": "XL"
                                        }
                                    }
                                },
                                {
                                    "code": "t_shirt_size_xxl",
                                    "translations": {
                                        "de": {
                                            "locale": "de",
                                            "id": 14,
                                            "value": "XXL"
                                        }
                                    }
                                }
                            ],
                            "translations": {
                                "de": {
                                    "locale": "de",
                                    "id": 4,
                                    "name": "T-Shirt size"
                                }
                            },
                            "_links": {
                                "self": {
                                    "href": "/api/v1/product-options/t_shirt_size"
                                }
                            }
                        }
                    ],
                    "associations": [],
                    "translations": {
                        "de": {
                            "locale": "de",
                            "id": 60,
                            "name": "T-Shirt \"voluptate\"",
                            "slug": "t-shirt-voluptate",
                            "description": "Dolores placeat non qui tenetur totam corrupti. Officiis totam sunt tempore repellendus officiis. Modi laboriosam ex ut ratione praesentium eum.\n\nMolestias atque quae voluptatem quas. Officiis rerum sapiente vero praesentium. Natus sed consequatur saepe aut.\n\nArchitecto libero dolore distinctio qui totam placeat. Error facere iste et. Similique dolorem dolorum molestias est. Aut officia consectetur a voluptatum.",
                            "shortDescription": "Enim quia quos a quaerat illo impedit minima. Mollitia consectetur consequatur nobis ut similique nobis. Magnam dolores perspiciatis deserunt voluptas fuga commodi. Numquam laboriosam molestiae et reprehenderit vel neque."
                        }
                    },
                    "productTaxons": [
                        {
                            "id": 74,
                            "taxon": {
                                "name": "T-Shirts",
                                "id": 5,
                                "code": "t_shirts",
                                "root": {
                                    "name": "Category",
                                    "id": 1,
                                    "code": "category",
                                    "children": [
                                        {
                                            "name": "Mugs",
                                            "id": 2,
                                            "code": "mugs",
                                            "children": [],
                                            "left": 2,
                                            "right": 3,
                                            "level": 1,
                                            "position": 0,
                                            "translations": [],
                                            "images": [],
                                            "_links": {
                                                "self": {
                                                    "href": "/api/v1/taxons/mugs"
                                                }
                                            }
                                        },
                                        {
                                            "name": "Stickers",
                                            "id": 3,
                                            "code": "stickers",
                                            "children": [],
                                            "left": 4,
                                            "right": 5,
                                            "level": 1,
                                            "position": 1,
                                            "translations": [],
                                            "images": [],
                                            "_links": {
                                                "self": {
                                                    "href": "/api/v1/taxons/stickers"
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
                                            "position": 2,
                                            "translations": [],
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
                                            "name": "Category",
                                            "slug": "category",
                                            "description": "Soluta qui iusto ex quo. Aut qui ad incidunt voluptatem repellendus quaerat illum. Eos ut quas molestias nihil. Veritatis aspernatur dicta ipsa blanditiis."
                                        }
                                    },
                                    "images": [],
                                    "_links": {
                                        "self": {
                                            "href": "/api/v1/taxons/category"
                                        }
                                    }
                                },
                                "parent": {
                                    "name": "Category",
                                    "id": 1,
                                    "code": "category",
                                    "children": [
                                        {
                                            "name": "Mugs",
                                            "id": 2,
                                            "code": "mugs",
                                            "children": [],
                                            "left": 2,
                                            "right": 3,
                                            "level": 1,
                                            "position": 0,
                                            "translations": [],
                                            "images": [],
                                            "_links": {
                                                "self": {
                                                    "href": "/api/v1/taxons/mugs"
                                                }
                                            }
                                        },
                                        {
                                            "name": "Stickers",
                                            "id": 3,
                                            "code": "stickers",
                                            "children": [],
                                            "left": 4,
                                            "right": 5,
                                            "level": 1,
                                            "position": 1,
                                            "translations": [],
                                            "images": [],
                                            "_links": {
                                                "self": {
                                                    "href": "/api/v1/taxons/stickers"
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
                                            "position": 2,
                                            "translations": [],
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
                                            "name": "Category",
                                            "slug": "category",
                                            "description": "Soluta qui iusto ex quo. Aut qui ad incidunt voluptatem repellendus quaerat illum. Eos ut quas molestias nihil. Veritatis aspernatur dicta ipsa blanditiis."
                                        }
                                    },
                                    "images": [],
                                    "_links": {
                                        "self": {
                                            "href": "/api/v1/taxons/category"
                                        }
                                    }
                                },
                                "children": [
                                    {
                                        "name": "Men",
                                        "id": 6,
                                        "code": "mens_t_shirts",
                                        "root": {
                                            "name": "Category",
                                            "id": 1,
                                            "code": "category",
                                            "children": [
                                                {
                                                    "name": "Mugs",
                                                    "id": 2,
                                                    "code": "mugs",
                                                    "children": [],
                                                    "left": 2,
                                                    "right": 3,
                                                    "level": 1,
                                                    "position": 0,
                                                    "translations": [],
                                                    "images": [],
                                                    "_links": {
                                                        "self": {
                                                            "href": "/api/v1/taxons/mugs"
                                                        }
                                                    }
                                                },
                                                {
                                                    "name": "Stickers",
                                                    "id": 3,
                                                    "code": "stickers",
                                                    "children": [],
                                                    "left": 4,
                                                    "right": 5,
                                                    "level": 1,
                                                    "position": 1,
                                                    "translations": [],
                                                    "images": [],
                                                    "_links": {
                                                        "self": {
                                                            "href": "/api/v1/taxons/stickers"
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
                                                    "position": 2,
                                                    "translations": [],
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
                                                    "name": "Category",
                                                    "slug": "category",
                                                    "description": "Soluta qui iusto ex quo. Aut qui ad incidunt voluptatem repellendus quaerat illum. Eos ut quas molestias nihil. Veritatis aspernatur dicta ipsa blanditiis."
                                                }
                                            },
                                            "images": [],
                                            "_links": {
                                                "self": {
                                                    "href": "/api/v1/taxons/category"
                                                }
                                            }
                                        },
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
                                        "name": "Women",
                                        "id": 7,
                                        "code": "womens_t_shirts",
                                        "root": {
                                            "name": "Category",
                                            "id": 1,
                                            "code": "category",
                                            "children": [
                                                {
                                                    "name": "Mugs",
                                                    "id": 2,
                                                    "code": "mugs",
                                                    "children": [],
                                                    "left": 2,
                                                    "right": 3,
                                                    "level": 1,
                                                    "position": 0,
                                                    "translations": [],
                                                    "images": [],
                                                    "_links": {
                                                        "self": {
                                                            "href": "/api/v1/taxons/mugs"
                                                        }
                                                    }
                                                },
                                                {
                                                    "name": "Stickers",
                                                    "id": 3,
                                                    "code": "stickers",
                                                    "children": [],
                                                    "left": 4,
                                                    "right": 5,
                                                    "level": 1,
                                                    "position": 1,
                                                    "translations": [],
                                                    "images": [],
                                                    "_links": {
                                                        "self": {
                                                            "href": "/api/v1/taxons/stickers"
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
                                                    "position": 2,
                                                    "translations": [],
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
                                                    "name": "Category",
                                                    "slug": "category",
                                                    "description": "Soluta qui iusto ex quo. Aut qui ad incidunt voluptatem repellendus quaerat illum. Eos ut quas molestias nihil. Veritatis aspernatur dicta ipsa blanditiis."
                                                }
                                            },
                                            "images": [],
                                            "_links": {
                                                "self": {
                                                    "href": "/api/v1/taxons/category"
                                                }
                                            }
                                        },
                                        "children": [],
                                        "left": 11,
                                        "right": 12,
                                        "level": 2,
                                        "position": 1,
                                        "translations": {
                                            "de": {
                                                "locale": "de",
                                                "id": 7,
                                                "name": "Women",
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
                                "position": 3,
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
                            "position": 14
                        },
                        {
                            "id": 75,
                            "taxon": {
                                "name": "Women",
                                "id": 7,
                                "code": "womens_t_shirts",
                                "root": {
                                    "name": "Category",
                                    "id": 1,
                                    "code": "category",
                                    "children": [
                                        {
                                            "name": "Mugs",
                                            "id": 2,
                                            "code": "mugs",
                                            "children": [],
                                            "left": 2,
                                            "right": 3,
                                            "level": 1,
                                            "position": 0,
                                            "translations": [],
                                            "images": [],
                                            "_links": {
                                                "self": {
                                                    "href": "/api/v1/taxons/mugs"
                                                }
                                            }
                                        },
                                        {
                                            "name": "Stickers",
                                            "id": 3,
                                            "code": "stickers",
                                            "children": [],
                                            "left": 4,
                                            "right": 5,
                                            "level": 1,
                                            "position": 1,
                                            "translations": [],
                                            "images": [],
                                            "_links": {
                                                "self": {
                                                    "href": "/api/v1/taxons/stickers"
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
                                            "position": 2,
                                            "translations": [],
                                            "images": [],
                                            "_links": {
                                                "self": {
                                                    "href": "/api/v1/taxons/books"
                                                }
                                            }
                                        },
                                        {
                                            "name": "T-Shirts",
                                            "id": 5,
                                            "code": "t_shirts",
                                            "children": [],
                                            "left": 8,
                                            "right": 13,
                                            "level": 1,
                                            "position": 3,
                                            "translations": [],
                                            "images": [],
                                            "_links": {
                                                "self": {
                                                    "href": "/api/v1/taxons/t_shirts"
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
                                            "name": "Category",
                                            "slug": "category",
                                            "description": "Soluta qui iusto ex quo. Aut qui ad incidunt voluptatem repellendus quaerat illum. Eos ut quas molestias nihil. Veritatis aspernatur dicta ipsa blanditiis."
                                        }
                                    },
                                    "images": [],
                                    "_links": {
                                        "self": {
                                            "href": "/api/v1/taxons/category"
                                        }
                                    }
                                },
                                "parent": {
                                    "name": "T-Shirts",
                                    "id": 5,
                                    "code": "t_shirts",
                                    "root": {
                                        "name": "Category",
                                        "id": 1,
                                        "code": "category",
                                        "children": [],
                                        "left": 1,
                                        "right": 14,
                                        "level": 0,
                                        "position": 0,
                                        "translations": [],
                                        "images": [],
                                        "_links": {
                                            "self": {
                                                "href": "/api/v1/taxons/category"
                                            }
                                        }
                                    },
                                    "parent": {
                                        "name": "Category",
                                        "id": 1,
                                        "code": "category",
                                        "children": [],
                                        "left": 1,
                                        "right": 14,
                                        "level": 0,
                                        "position": 0,
                                        "translations": [],
                                        "images": [],
                                        "_links": {
                                            "self": {
                                                "href": "/api/v1/taxons/category"
                                            }
                                        }
                                    },
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
                                            "translations": [],
                                            "images": [],
                                            "_links": {
                                                "self": {
                                                    "href": "/api/v1/taxons/mens_t_shirts"
                                                }
                                            }
                                        }
                                    ],
                                    "left": 8,
                                    "right": 13,
                                    "level": 1,
                                    "position": 3,
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
                                "children": [],
                                "left": 11,
                                "right": 12,
                                "level": 2,
                                "position": 1,
                                "translations": {
                                    "de": {
                                        "locale": "de",
                                        "id": 7,
                                        "name": "Women",
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
                            },
                            "position": 6
                        }
                    ],
                    "channels": [
                        {
                            "id": 2,
                            "code": "US_WEB",
                            "name": "US Web Store",
                            "hostname": "localhost",
                            "color": "Wheat",
                            "createdAt": "2018-10-16T14:20:22+02:00",
                            "updatedAt": "2018-10-16T14:21:04+02:00",
                            "enabled": true,
                            "taxCalculationStrategy": "order_items_based",
                            "_links": {
                                "self": {
                                    "href": "/api/v1/channels/US_WEB"
                                }
                            }
                        }
                    ],
                    "mainTaxon": {
                        "name": "Women",
                        "id": 7,
                        "code": "womens_t_shirts",
                        "root": {
                            "name": "Category",
                            "id": 1,
                            "code": "category",
                            "children": [
                                {
                                    "name": "Mugs",
                                    "id": 2,
                                    "code": "mugs",
                                    "children": [],
                                    "left": 2,
                                    "right": 3,
                                    "level": 1,
                                    "position": 0,
                                    "translations": [],
                                    "images": [],
                                    "_links": {
                                        "self": {
                                            "href": "/api/v1/taxons/mugs"
                                        }
                                    }
                                },
                                {
                                    "name": "Stickers",
                                    "id": 3,
                                    "code": "stickers",
                                    "children": [],
                                    "left": 4,
                                    "right": 5,
                                    "level": 1,
                                    "position": 1,
                                    "translations": [],
                                    "images": [],
                                    "_links": {
                                        "self": {
                                            "href": "/api/v1/taxons/stickers"
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
                                    "position": 2,
                                    "translations": [],
                                    "images": [],
                                    "_links": {
                                        "self": {
                                            "href": "/api/v1/taxons/books"
                                        }
                                    }
                                },
                                {
                                    "name": "T-Shirts",
                                    "id": 5,
                                    "code": "t_shirts",
                                    "children": [],
                                    "left": 8,
                                    "right": 13,
                                    "level": 1,
                                    "position": 3,
                                    "translations": [],
                                    "images": [],
                                    "_links": {
                                        "self": {
                                            "href": "/api/v1/taxons/t_shirts"
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
                                    "name": "Category",
                                    "slug": "category",
                                    "description": "Soluta qui iusto ex quo. Aut qui ad incidunt voluptatem repellendus quaerat illum. Eos ut quas molestias nihil. Veritatis aspernatur dicta ipsa blanditiis."
                                }
                            },
                            "images": [],
                            "_links": {
                                "self": {
                                    "href": "/api/v1/taxons/category"
                                }
                            }
                        },
                        "parent": {
                            "name": "T-Shirts",
                            "id": 5,
                            "code": "t_shirts",
                            "root": {
                                "name": "Category",
                                "id": 1,
                                "code": "category",
                                "children": [],
                                "left": 1,
                                "right": 14,
                                "level": 0,
                                "position": 0,
                                "translations": [],
                                "images": [],
                                "_links": {
                                    "self": {
                                        "href": "/api/v1/taxons/category"
                                    }
                                }
                            },
                            "parent": {
                                "name": "Category",
                                "id": 1,
                                "code": "category",
                                "children": [],
                                "left": 1,
                                "right": 14,
                                "level": 0,
                                "position": 0,
                                "translations": [],
                                "images": [],
                                "_links": {
                                    "self": {
                                        "href": "/api/v1/taxons/category"
                                    }
                                }
                            },
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
                                    "translations": [],
                                    "images": [],
                                    "_links": {
                                        "self": {
                                            "href": "/api/v1/taxons/mens_t_shirts"
                                        }
                                    }
                                }
                            ],
                            "left": 8,
                            "right": 13,
                            "level": 1,
                            "position": 3,
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
                        "children": [],
                        "left": 11,
                        "right": 12,
                        "level": 2,
                        "position": 1,
                        "translations": {
                            "de": {
                                "locale": "de",
                                "id": 7,
                                "name": "Women",
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
                    },
                    "reviews": [],
                    "averageRating": 0.0,
                    "images": [
                        {
                            "id": 119,
                            "type": "main",
                            "path": "13/c7/0c2969778bc24385ad7d8bacdbab.jpeg"
                        },
                        {
                            "id": 120,
                            "type": "thumbnail",
                            "path": "fe/ca/8dd81fd04d5f01bfda776263fb9d.jpeg"
                        }
                    ],
                    "_links": {
                        "self": {
                            "href": "/api/v1/products/f8ed6a6f-a908-3401-b200-45a6e2756e3c"
                        },
                        "variants": {
                            "href": "/api/v1/products/f8ed6a6f-a908-3401-b200-45a6e2756e3c/variants/"
                        }
                    }
                }
            ]
        }
    ],
    "translations": {
        "de": {
            "locale": "de",
            "id": 53,
            "name": "T-Shirt \"nihil\"",
            "slug": "t-shirt-nihil",
            "description": "Similique autem culpa perferendis minima commodi sed fugiat iste. Sunt et quidem optio labore soluta. Quia velit soluta iste consectetur qui odit qui.\r\n\r\nIpsa et porro occaecati nesciunt tempore. Iste itaque impedit est. Quis suscipit at similique est aut repellendus. Ut ad impedit ut ea totam eius.\r\n\r\nQui perspiciatis nam est vitae sequi saepe. Ratione sed et sunt sequi quasi molestiae sed. Voluptatem sed voluptates ut officia sit. Blanditiis voluptas praesentium a ut culpa.",
            "shortDescription": "Qui reiciendis mollitia possimus expedita voluptates. Rerum odit modi ipsam omnis aliquid iusto. Nisi corporis rerum aut corporis. Aut exercitationem at consequatur non."
        }
    },
    "productTaxons": [
        {
            "id": 60,
            "taxon": {
                "name": "T-Shirts",
                "id": 5,
                "code": "t_shirts",
                "root": {
                    "name": "Category",
                    "id": 1,
                    "code": "category",
                    "children": [
                        {
                            "name": "Mugs",
                            "id": 2,
                            "code": "mugs",
                            "children": [],
                            "left": 2,
                            "right": 3,
                            "level": 1,
                            "position": 0,
                            "translations": [],
                            "images": [],
                            "_links": {
                                "self": {
                                    "href": "/api/v1/taxons/mugs"
                                }
                            }
                        },
                        {
                            "name": "Stickers",
                            "id": 3,
                            "code": "stickers",
                            "children": [],
                            "left": 4,
                            "right": 5,
                            "level": 1,
                            "position": 1,
                            "translations": [],
                            "images": [],
                            "_links": {
                                "self": {
                                    "href": "/api/v1/taxons/stickers"
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
                            "position": 2,
                            "translations": [],
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
                            "name": "Category",
                            "slug": "category",
                            "description": "Soluta qui iusto ex quo. Aut qui ad incidunt voluptatem repellendus quaerat illum. Eos ut quas molestias nihil. Veritatis aspernatur dicta ipsa blanditiis."
                        }
                    },
                    "images": [],
                    "_links": {
                        "self": {
                            "href": "/api/v1/taxons/category"
                        }
                    }
                },
                "parent": {
                    "name": "Category",
                    "id": 1,
                    "code": "category",
                    "children": [
                        {
                            "name": "Mugs",
                            "id": 2,
                            "code": "mugs",
                            "children": [],
                            "left": 2,
                            "right": 3,
                            "level": 1,
                            "position": 0,
                            "translations": [],
                            "images": [],
                            "_links": {
                                "self": {
                                    "href": "/api/v1/taxons/mugs"
                                }
                            }
                        },
                        {
                            "name": "Stickers",
                            "id": 3,
                            "code": "stickers",
                            "children": [],
                            "left": 4,
                            "right": 5,
                            "level": 1,
                            "position": 1,
                            "translations": [],
                            "images": [],
                            "_links": {
                                "self": {
                                    "href": "/api/v1/taxons/stickers"
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
                            "position": 2,
                            "translations": [],
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
                            "name": "Category",
                            "slug": "category",
                            "description": "Soluta qui iusto ex quo. Aut qui ad incidunt voluptatem repellendus quaerat illum. Eos ut quas molestias nihil. Veritatis aspernatur dicta ipsa blanditiis."
                        }
                    },
                    "images": [],
                    "_links": {
                        "self": {
                            "href": "/api/v1/taxons/category"
                        }
                    }
                },
                "children": [
                    {
                        "name": "Men",
                        "id": 6,
                        "code": "mens_t_shirts",
                        "root": {
                            "name": "Category",
                            "id": 1,
                            "code": "category",
                            "children": [
                                {
                                    "name": "Mugs",
                                    "id": 2,
                                    "code": "mugs",
                                    "children": [],
                                    "left": 2,
                                    "right": 3,
                                    "level": 1,
                                    "position": 0,
                                    "translations": [],
                                    "images": [],
                                    "_links": {
                                        "self": {
                                            "href": "/api/v1/taxons/mugs"
                                        }
                                    }
                                },
                                {
                                    "name": "Stickers",
                                    "id": 3,
                                    "code": "stickers",
                                    "children": [],
                                    "left": 4,
                                    "right": 5,
                                    "level": 1,
                                    "position": 1,
                                    "translations": [],
                                    "images": [],
                                    "_links": {
                                        "self": {
                                            "href": "/api/v1/taxons/stickers"
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
                                    "position": 2,
                                    "translations": [],
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
                                    "name": "Category",
                                    "slug": "category",
                                    "description": "Soluta qui iusto ex quo. Aut qui ad incidunt voluptatem repellendus quaerat illum. Eos ut quas molestias nihil. Veritatis aspernatur dicta ipsa blanditiis."
                                }
                            },
                            "images": [],
                            "_links": {
                                "self": {
                                    "href": "/api/v1/taxons/category"
                                }
                            }
                        },
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
                        "name": "Women",
                        "id": 7,
                        "code": "womens_t_shirts",
                        "root": {
                            "name": "Category",
                            "id": 1,
                            "code": "category",
                            "children": [
                                {
                                    "name": "Mugs",
                                    "id": 2,
                                    "code": "mugs",
                                    "children": [],
                                    "left": 2,
                                    "right": 3,
                                    "level": 1,
                                    "position": 0,
                                    "translations": [],
                                    "images": [],
                                    "_links": {
                                        "self": {
                                            "href": "/api/v1/taxons/mugs"
                                        }
                                    }
                                },
                                {
                                    "name": "Stickers",
                                    "id": 3,
                                    "code": "stickers",
                                    "children": [],
                                    "left": 4,
                                    "right": 5,
                                    "level": 1,
                                    "position": 1,
                                    "translations": [],
                                    "images": [],
                                    "_links": {
                                        "self": {
                                            "href": "/api/v1/taxons/stickers"
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
                                    "position": 2,
                                    "translations": [],
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
                                    "name": "Category",
                                    "slug": "category",
                                    "description": "Soluta qui iusto ex quo. Aut qui ad incidunt voluptatem repellendus quaerat illum. Eos ut quas molestias nihil. Veritatis aspernatur dicta ipsa blanditiis."
                                }
                            },
                            "images": [],
                            "_links": {
                                "self": {
                                    "href": "/api/v1/taxons/category"
                                }
                            }
                        },
                        "children": [],
                        "left": 11,
                        "right": 12,
                        "level": 2,
                        "position": 1,
                        "translations": {
                            "de": {
                                "locale": "de",
                                "id": 7,
                                "name": "Women",
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
                "position": 3,
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
            "position": 7
        },
        {
            "id": 61,
            "taxon": {
                "name": "Women",
                "id": 7,
                "code": "womens_t_shirts",
                "root": {
                    "name": "Category",
                    "id": 1,
                    "code": "category",
                    "children": [
                        {
                            "name": "Mugs",
                            "id": 2,
                            "code": "mugs",
                            "children": [],
                            "left": 2,
                            "right": 3,
                            "level": 1,
                            "position": 0,
                            "translations": [],
                            "images": [],
                            "_links": {
                                "self": {
                                    "href": "/api/v1/taxons/mugs"
                                }
                            }
                        },
                        {
                            "name": "Stickers",
                            "id": 3,
                            "code": "stickers",
                            "children": [],
                            "left": 4,
                            "right": 5,
                            "level": 1,
                            "position": 1,
                            "translations": [],
                            "images": [],
                            "_links": {
                                "self": {
                                    "href": "/api/v1/taxons/stickers"
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
                            "position": 2,
                            "translations": [],
                            "images": [],
                            "_links": {
                                "self": {
                                    "href": "/api/v1/taxons/books"
                                }
                            }
                        },
                        {
                            "name": "T-Shirts",
                            "id": 5,
                            "code": "t_shirts",
                            "children": [],
                            "left": 8,
                            "right": 13,
                            "level": 1,
                            "position": 3,
                            "translations": [],
                            "images": [],
                            "_links": {
                                "self": {
                                    "href": "/api/v1/taxons/t_shirts"
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
                            "name": "Category",
                            "slug": "category",
                            "description": "Soluta qui iusto ex quo. Aut qui ad incidunt voluptatem repellendus quaerat illum. Eos ut quas molestias nihil. Veritatis aspernatur dicta ipsa blanditiis."
                        }
                    },
                    "images": [],
                    "_links": {
                        "self": {
                            "href": "/api/v1/taxons/category"
                        }
                    }
                },
                "parent": {
                    "name": "T-Shirts",
                    "id": 5,
                    "code": "t_shirts",
                    "root": {
                        "name": "Category",
                        "id": 1,
                        "code": "category",
                        "children": [],
                        "left": 1,
                        "right": 14,
                        "level": 0,
                        "position": 0,
                        "translations": [],
                        "images": [],
                        "_links": {
                            "self": {
                                "href": "/api/v1/taxons/category"
                            }
                        }
                    },
                    "parent": {
                        "name": "Category",
                        "id": 1,
                        "code": "category",
                        "children": [],
                        "left": 1,
                        "right": 14,
                        "level": 0,
                        "position": 0,
                        "translations": [],
                        "images": [],
                        "_links": {
                            "self": {
                                "href": "/api/v1/taxons/category"
                            }
                        }
                    },
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
                            "translations": [],
                            "images": [],
                            "_links": {
                                "self": {
                                    "href": "/api/v1/taxons/mens_t_shirts"
                                }
                            }
                        }
                    ],
                    "left": 8,
                    "right": 13,
                    "level": 1,
                    "position": 3,
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
                "children": [],
                "left": 11,
                "right": 12,
                "level": 2,
                "position": 1,
                "translations": {
                    "de": {
                        "locale": "de",
                        "id": 7,
                        "name": "Women",
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
            },
            "position": 4
        }
    ],
    "channels": [
        {
            "id": 2,
            "code": "US_WEB",
            "name": "US Web Store",
            "hostname": "localhost",
            "color": "Wheat",
            "createdAt": "2018-10-16T14:20:22+02:00",
            "updatedAt": "2018-10-16T14:21:04+02:00",
            "enabled": true,
            "taxCalculationStrategy": "order_items_based",
            "_links": {
                "self": {
                    "href": "/api/v1/channels/US_WEB"
                }
            }
        }
    ],
    "mainTaxon": {
        "name": "Women",
        "id": 7,
        "code": "womens_t_shirts",
        "root": {
            "name": "Category",
            "id": 1,
            "code": "category",
            "children": [
                {
                    "name": "Mugs",
                    "id": 2,
                    "code": "mugs",
                    "children": [],
                    "left": 2,
                    "right": 3,
                    "level": 1,
                    "position": 0,
                    "translations": [],
                    "images": [],
                    "_links": {
                        "self": {
                            "href": "/api/v1/taxons/mugs"
                        }
                    }
                },
                {
                    "name": "Stickers",
                    "id": 3,
                    "code": "stickers",
                    "children": [],
                    "left": 4,
                    "right": 5,
                    "level": 1,
                    "position": 1,
                    "translations": [],
                    "images": [],
                    "_links": {
                        "self": {
                            "href": "/api/v1/taxons/stickers"
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
                    "position": 2,
                    "translations": [],
                    "images": [],
                    "_links": {
                        "self": {
                            "href": "/api/v1/taxons/books"
                        }
                    }
                },
                {
                    "name": "T-Shirts",
                    "id": 5,
                    "code": "t_shirts",
                    "children": [],
                    "left": 8,
                    "right": 13,
                    "level": 1,
                    "position": 3,
                    "translations": [],
                    "images": [],
                    "_links": {
                        "self": {
                            "href": "/api/v1/taxons/t_shirts"
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
                    "name": "Category",
                    "slug": "category",
                    "description": "Soluta qui iusto ex quo. Aut qui ad incidunt voluptatem repellendus quaerat illum. Eos ut quas molestias nihil. Veritatis aspernatur dicta ipsa blanditiis."
                }
            },
            "images": [],
            "_links": {
                "self": {
                    "href": "/api/v1/taxons/category"
                }
            }
        },
        "parent": {
            "name": "T-Shirts",
            "id": 5,
            "code": "t_shirts",
            "root": {
                "name": "Category",
                "id": 1,
                "code": "category",
                "children": [],
                "left": 1,
                "right": 14,
                "level": 0,
                "position": 0,
                "translations": [],
                "images": [],
                "_links": {
                    "self": {
                        "href": "/api/v1/taxons/category"
                    }
                }
            },
            "parent": {
                "name": "Category",
                "id": 1,
                "code": "category",
                "children": [],
                "left": 1,
                "right": 14,
                "level": 0,
                "position": 0,
                "translations": [],
                "images": [],
                "_links": {
                    "self": {
                        "href": "/api/v1/taxons/category"
                    }
                }
            },
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
                    "translations": [],
                    "images": [],
                    "_links": {
                        "self": {
                            "href": "/api/v1/taxons/mens_t_shirts"
                        }
                    }
                }
            ],
            "left": 8,
            "right": 13,
            "level": 1,
            "position": 3,
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
        "children": [],
        "left": 11,
        "right": 12,
        "level": 2,
        "position": 1,
        "translations": {
            "de": {
                "locale": "de",
                "id": 7,
                "name": "Women",
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
    },
    "reviews": [
        {
            "id": 26,
            "title": "aperiam eaque consequatur",
            "rating": 2,
            "comment": "Deserunt mollitia veniam voluptatem et tempora. Natus quidem delectus voluptas. Et perferendis ex aut dolorum.",
            "author": {
                "id": 18,
                "email": "katheryn28@cummings.info",
                "emailCanonical": "katheryn28@cummings.info",
                "firstName": "Charity",
                "lastName": "Abernathy",
                "gender": "u",
                "group": {
                    "id": 1,
                    "code": "retail",
                    "name": "Retail"
                },
                "user": {
                    "id": 18,
                    "roles": [
                        "ROLE_USER"
                    ],
                    "enabled": true
                },
                "_links": {
                    "self": {
                        "href": "/api/v1/customers/18"
                    }
                }
            },
            "status": "rejected",
            "createdAt": "2018-10-16T14:20:42+02:00",
            "updatedAt": "2018-10-16T14:20:42+02:00"
        },
        {
            "id": 33,
            "title": "et iure deleniti",
            "rating": 3,
            "comment": "Veniam id iure aut qui rerum omnis tempora expedita. Aut deleniti et ut libero dolores repudiandae unde. Est dolore suscipit laborum ut quae sed.",
            "author": {
                "id": 11,
                "email": "pearline25@yahoo.com",
                "emailCanonical": "pearline25@yahoo.com",
                "firstName": "Eunice",
                "lastName": "Kihn",
                "gender": "u",
                "group": {
                    "id": 2,
                    "code": "wholesale",
                    "name": "Wholesale"
                },
                "user": {
                    "id": 11,
                    "roles": [
                        "ROLE_USER"
                    ],
                    "enabled": true
                },
                "_links": {
                    "self": {
                        "href": "/api/v1/customers/11"
                    }
                }
            },
            "status": "rejected",
            "createdAt": "2018-10-16T14:20:44+02:00",
            "updatedAt": "2018-10-16T14:20:44+02:00"
        }
    ],
    "averageRating": 0.0,
    "images": [
        {
            "id": 105,
            "type": "main",
            "path": "1c/e1/faae0526152d28b9a35deaee8380.jpeg"
        },
        {
            "id": 106,
            "type": "thumbnail",
            "path": "c9/57/e8a2d7f92c6e44f5c15561fcb68d.jpeg"
        }
    ],
    "_links": {
        "self": {
            "href": "/api/v1/products/0602fd01-1e26-313f-9544-420369277dd6"
        },
        "variants": {
            "href": "/api/v1/products/0602fd01-1e26-313f-9544-420369277dd6/variants/"
        }
    }
}', true);
    }
}