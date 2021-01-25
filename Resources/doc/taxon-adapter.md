# Taxon Adapter

The Taxon Adapter is used to synchronize the taxons from sylius to sulu.

## Built in Adapter

For the taxons there is a default built in adapter to synchronize the taxons to categories. This adapter is disabled by
default.

To enable it use following configuration:

```yaml
sulu_sylius_consumer:
    taxon_category_adapter:
        enabled: true
```

## Custom Adapter

If you want to add your custom adapter to synchronize taxons to your e.g. custom entity or pages you can add you own 
adapter.

```php
<?php

namespace App\Adapter;

use Sulu\Bundle\SyliusConsumerBundle\TaxonAdapterInterface;

class CustomTaxonAdapter implements TaxonAdapterInterface
{
    public function synchronize(TaxonPayload $payload): void
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
`sulu_sylius_consumer.adapter.taxon` to your service definition.

```yaml
services:
    App\Adapter\CustomTaxonAdapter:
        tags:
            - 'sulu_sylius_consumer.adapter.taxon'
```
