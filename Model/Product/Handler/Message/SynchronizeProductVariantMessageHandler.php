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

use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\SynchronizeProductVariantMessage;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductVariantInformationRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductVariantInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductVariantRepositoryInterface;

class SynchronizeProductVariantMessageHandler
{
    use SynchronizeProductVariantTrait {
        __construct as initializeSynchronizeProductVariantTrait;
    }

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var ProductVariantRepositoryInterface
     */
    private $productVariantRepository;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        ProductVariantRepositoryInterface $productionVariantRepository,
        ProductVariantInformationRepositoryInterface $productVariantInformationRepository,
        DimensionRepositoryInterface $dimensionRepository
    ) {
        $this->productRepository = $productRepository;
        $this->productVariantRepository = $productionVariantRepository;

        $this->initializeSynchronizeProductVariantTrait(
            $productRepository,
            $productionVariantRepository,
            $productVariantInformationRepository,
            $dimensionRepository
        );
    }

    public function __invoke(SynchronizeProductVariantMessage $message): ProductVariantInterface
    {
        $product = $this->productRepository->findByCode($message->getProductCode());
        if (!$product) {
            throw new \InvalidArgumentException('Product with code "' . $message->getProductCode() . '" not found');
        }

        $productVariant = $product->findVariantByCode($message->getCode());
        if (!$productVariant) {
            $productVariant = $this->productVariantRepository->create($product, $message->getCode());
        }

        $this->synchronizeProductVariant($message, $productVariant);

        return $productVariant;
    }
}
