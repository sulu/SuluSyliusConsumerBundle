# Installation

## Install dependencies

```bash
composer require sulu/sylius-consumer-plugin
```

### Configure SuluSyliusConsumerBundle and symfony messenger

```yaml
# sulu/config/packages/sulu_sylius_consumer.yaml
 
sulu_sylius_consumer:
    sylius_base_url: '%env(SYLIUS_BASE_URL)%'

framework:
    messenger:
        transports:
            sulu_sylius_transport: '%env(SULU_SYLIUS_MESSENGER_TRANSPORT_DSN)%'
        buses:
            sulu_sylius_producer.messenger_bus:
                middleware:
                    - doctrine_transaction
```
