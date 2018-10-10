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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Product\Handler\Message;

use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Exception\ProductNotFoundException;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\RemoveProductMessage;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductRepositoryInterface;

class RemoveProductMessageHandler
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function __invoke(RemoveProductMessage $message): void
    {
        $product = $this->productRepository->findByCode($message->getCode());
        if (!$product) {
            throw new ProductNotFoundException($message->getCode());
        }

        $this->productRepository->remove($product);
    }
}
