# Product Adapter

The Product Adapter is used to synchronize the products from sylius to sulu.

## Custom Adapter

If you want to add your custom adapter to synchronize products to your e.g. custom entity or articles you can add your
own adapter.

```php
<?php

namespace App\Adapter;

use Sulu\Bundle\SyliusConsumerBundle\ProductAdapterInterface;

class CustomProductAdapter implements ProductAdapterInterface
{
    public function synchronize(ProductPayload $payload): void
    {
        ...
    }

    public function remove(int $id): void
    {
        ...
    }
}
```

If you have activated the autoconfiguration for your services it should already work. Else you have to add the tag
`sulu_sylius_consumer.adapter.product` to your service definition.

```yaml
services:
    App\Adapter\CustomProductAdapter:
        tags:
            - 'sulu_sylius_consumer.adapter.product'
```

## Sulu Product Adapter

With `sulu/product-bundle` installed, the built-in adapter writes products and variants into Sulu products.
Products are matched by their Sylius code, so a second synchronization updates instead of duplicating.

```yaml
sulu_sylius_consumer:
    product_adapter:
        enabled: true
        locales: [en, de] # Sulu languages, the first one is the default
        family_key: sylius
        template: product
        url_prefix: /products/
```

A simple Sylius product becomes a `product`. A product with variants becomes a `product_with_variants`
and its variants become `variant` children, which own the URL. Images and categories are linked when the
`image_media_adapter` and the `taxon_category_adapter` are enabled.
