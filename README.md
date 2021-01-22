# SuluSyliusConsumerBundle

[![Test Application](https://img.shields.io/github/workflow/status/sulu/SuluSyliusConsumerPlugin/Test%20application.svg?label=Test-Application)](https://github.com/sulu/SuluSyliusConsumerPlugin/actions)

Consumer for synchronization products with sylius.

## Installation

```bash
composer require sulu/sylius-consumer-plugin
```

### Register the plugin

```bash
// config/bundles.php

    Sulu\SyliusConsumerBundle\SuluSyliusConsumerBundle::class => ['all' => true],
```
