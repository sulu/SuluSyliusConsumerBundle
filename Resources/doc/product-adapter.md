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
