# Upgrade

## Unreleased

### Sulu 3.1 required

The bundle requires `sulu/sulu` `^3.1` and PHP 8.2. Sulu 2.x is no longer supported.
The `ImageMediaAdapter` sets the media type as the string `image`, because Sulu 3 has no `MediaType` entity.

## 0.4.0

### Rework synchronization of taxon entities

The `SynchronizeTaxonMessage` as well as the `SynchronizeTaxonMessageHandler` has
been refactored to support the synchronization of multiple independent taxon
entities. Previously only the root node could be synchronized, which resulted
in always synchronizing the complete tree structure.

`Sulu\Bundle\SyliusConsumerBundle\Message\SynchronizeTaxonMessage` renamed to `Sulu\Bundle\SyliusConsumerBundle\Message\SynchronizeTaxonsMessage`
`Sulu\Bundle\SyliusConsumerBundle\Handler\SynchronizeTaxonMessageHandler` renamed to `Sulu\Bundle\SyliusConsumerBundle\Handler\SynchronizeTaxonsMessageHandler`
