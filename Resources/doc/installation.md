# Installation

## Route generation

Add the following configuration for generating routes. This example shows the configuration for building the path by the code of the product:

```yaml
sulu_route:
    mappings:
        Sulu\Bundle\SyliusConsumerBundle\Model\RoutableResource\RoutableResource:
            generator: schema
            resource_key: products
            options:
                route_schema: "/products/{object.getCode()}"
```
