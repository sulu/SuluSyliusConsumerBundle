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

namespace Sulu\Bundle\SyliusConsumerBundle\Content;

use ProxyManager\Factory\LazyLoadingValueHolderFactory;
use ProxyManager\Proxy\LazyLoadingInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductViewInterface;
use Sulu\Bundle\SyliusConsumerBundle\Resolver\ProductViewContentResolverInterface;

class ProxyFactory
{
    /**
     * @var LazyLoadingValueHolderFactory
     */
    private $proxyFactory;

    /**
     * @var ProductViewContentResolverInterface
     */
    private $productViewContentResolver;

    public function __construct(
        LazyLoadingValueHolderFactory $proxyFactory,
        ProductViewContentResolverInterface $productViewContentResolver
    ) {
        $this->proxyFactory = $proxyFactory;
        $this->productViewContentResolver = $productViewContentResolver;
    }

    public function createProxy(ProductViewInterface $productView)
    {
        return $this->proxyFactory->createProxy(
            \ArrayObject::class,
            function (
                &$wrappedObject,
                LazyLoadingInterface $proxy,
                $method,
                array $parameters,
                &$initializer
            ) use ($productView) {
                $initializer = null;

                $serializedData = $this->productViewContentResolver->resolve($productView);
                $wrappedObject = new \ArrayObject($serializedData);

                return true;
            }
        );
    }

    /**
     * @param ProductViewInterface[] $productViews
     */
    public function createProxies(array $productViews)
    {
        return $this->proxyFactory->createProxy(
            \ArrayObject::class,
            function (
                &$wrappedObject,
                LazyLoadingInterface $proxy,
                $method,
                array $parameters,
                &$initializer
            ) use ($productViews) {
                $initializer = null;

                $serializedData = [];
                foreach ($productViews as $productView) {
                    $serializedData[] = $this->productViewContentResolver->resolve($productView);
                }
                $wrappedObject = new \ArrayObject($serializedData);

                return true;
            }
        );
    }
}
