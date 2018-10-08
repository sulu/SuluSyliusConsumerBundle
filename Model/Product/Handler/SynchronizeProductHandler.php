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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Product\Handler;

use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\ProductVariantDTO;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\SynchronizeProductMessage;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductVariantRepositoryInterface;

class SynchronizeProductHandler
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var ProductVariantRepositoryInterface
     */
    private $variantRepository;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        ProductVariantRepositoryInterface $variantRepository
    ) {
        $this->productRepository = $productRepository;
        $this->variantRepository = $variantRepository;
    }

    public function __invoke(SynchronizeProductMessage $message): ProductInterface
    {
        $productDTO = $message->getProduct();

        $product = $this->productRepository->findByCode($productDTO->getCode());
        if (!$product) {
            $product = $this->productRepository->create($productDTO->getCode());
        }

        $this->synchronizeVariants($productDTO->getVariants(), $product);

        return $product;
    }

    /**
     * @param ProductVariantDTO[] $variantDTOs
     */
    private function synchronizeVariants(array $variantDTOs, ProductInterface $product)
    {
        $codes = [];
        foreach ($variantDTOs as $variantDTO) {
            $variant = $product->findVariantByCode($variantDTO->getCode());
            if (!$variant) {
                $variant = $this->variantRepository->create($product, $variantDTO->getCode());
            }

            $codes[] = $variant->getCode();
        }

        foreach ($product->getVariants() as $variant) {
            if (!in_array($variant->getCode(), $codes)) {
                $product->removeVariant($variant);
            }
        }
    }
}
