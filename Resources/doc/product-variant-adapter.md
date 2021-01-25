# Product Variant Adapter

The ProductVariant Adapter is used to synchronize the Product Variants from sylius to sulu.

## Custom Adapter

If you want to add your custom adapter to synchronize Product Variants to your e.g. custom entity or articles you can
add your own adapter.

```php
<?php

namespace App\Adapter;

use Sulu\Bundle\SyliusConsumerBundle\ProductVariantAdapterInterface;

class CustomProductVariantAdapter implements ProductVariantAdapterInterface
{
    public function synchronize(ProductVariantPayload $payload): void
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
`sulu_sylius_consumer.adapter.product_variant` to your service definition.

```yaml
services:
    App\Adapter\CustomProductVariantAdapter:
        tags:
            - 'sulu_sylius_consumer.adapter.product_variant'
```
