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

namespace Sulu\Bundle\SyliusConsumerBundle\Routing;

use Sulu\Bundle\HttpCacheBundle\CacheLifetime\CacheLifetimeResolverInterface;
use Sulu\Bundle\RouteBundle\Routing\Defaults\RouteDefaultsProviderInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Exception\ProductInformationNotFoundException;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductViewInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Query\FindProductViewQuery;
use Sulu\Bundle\SyliusConsumerBundle\Model\RoutableResource\RoutableResourceInterface;
use Sulu\Component\Content\Metadata\Factory\StructureMetadataFactoryInterface;
use Sulu\Component\Content\Metadata\StructureMetadata;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;

class ProductRouteDefaultsProvider implements RouteDefaultsProviderInterface
{
    /**
     * @var MessageBusInterface
     */
    private $messagBus;

    /**
     * @var StructureMetadataFactoryInterface
     */
    private $structureMetadataFactory;

    /**
     * @var CacheLifetimeResolverInterface
     */
    private $cacheLifetimeResolver;

    /**
     * @var array
     */
    private $routeDefaultsFallback;

    public function __construct(
        MessageBusInterface $messagBus,
        StructureMetadataFactoryInterface $structureMetadataFactory,
        CacheLifetimeResolverInterface $cacheLifetimeResolver,
        array $routeDefaultsFallback
    ) {
        $this->messagBus = $messagBus;
        $this->structureMetadataFactory = $structureMetadataFactory;
        $this->cacheLifetimeResolver = $cacheLifetimeResolver;
        $this->routeDefaultsFallback = $routeDefaultsFallback;
    }

    /**
     * @param ProductViewInterface|null $object
     */
    public function getByEntity($entityClass, $id, $locale, $object = null)
    {
        if (!$object) {
            $object = $this->loadProduct($id, $locale);
        }

        $content = $object->getContent();
        if (!$content) {
            return array_merge(
                [
                    'object' => $object,
                ],
                $this->routeDefaultsFallback
            );
        }

        /** @var StructureMetadata $metadata */
        $metadata = $this->structureMetadataFactory->getStructureMetadata(
            ProductInterface::CONTENT_RESOURCE_KEY,
            $content->getType()
        );

        return [
            'object' => $object,
            'view' => $metadata->getView(),
            '_cacheLifetime' => $this->getCacheLifetime($metadata),
            '_controller' => $metadata->getController(),
        ];
    }

    public function isPublished($entityClass, $id, $locale)
    {
        try {
            $productView = $this->loadProduct($id, $locale);

            return $productView->getProduct()->isEnabled();
        } catch (HandlerFailedException $exception) {
            if (($exception->getNestedExceptions()[0] ?? null) instanceof ProductInformationNotFoundException) {
                return false;
            }

            throw $exception;
        }
    }

    public function supports($entityClass)
    {
        return is_subclass_of($entityClass, RoutableResourceInterface::class);
    }

    private function loadProduct(string $id, string $locale): ProductViewInterface
    {
        $message = new FindProductViewQuery($id, $locale);
        $this->messagBus->dispatch($message);

        return $message->getProductView();
    }

    private function getCacheLifetime(StructureMetadata $metadata): ?int
    {
        $cacheLifetime = $metadata->getCacheLifetime();
        if (!$cacheLifetime) {
            return null;
        }

        if (!is_array($cacheLifetime)
            || !isset($cacheLifetime['type'])
            || !isset($cacheLifetime['value'])
            || !$this->cacheLifetimeResolver->supports($cacheLifetime['type'], $cacheLifetime['value'])
        ) {
            throw new \InvalidArgumentException(
                sprintf('Invalid cachelifetime in product route default provider: %s', var_export($cacheLifetime, true))
            );
        }

        return $this->cacheLifetimeResolver->resolve($cacheLifetime['type'], $cacheLifetime['value']);
    }
}
