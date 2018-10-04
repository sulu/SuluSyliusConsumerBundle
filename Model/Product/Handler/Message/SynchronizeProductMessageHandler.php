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

use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\ProductVariantValueObject;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\SynchronizeProductMessage;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductVariantRepositoryInterface;

class SynchronizeProductMessageHandler
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var ProductVariantRepositoryInterface
     */
    private $variantRepository;

    /**
     * @var DimensionRepositoryInterface
     */
    private $dimensionRepository;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        ProductVariantRepositoryInterface $variantRepository,
        DimensionRepositoryInterface $dimensionRepository
    ) {
        $this->productRepository = $productRepository;
        $this->variantRepository = $variantRepository;
        $this->dimensionRepository = $dimensionRepository;
    }

    public function __invoke(SynchronizeProductMessage $message): ProductInterface
    {
        $dimension = $this->dimensionRepository->findOrCreateByAttributes(['workspace' => 'draft']);

        $product = $this->productRepository->findByCode($dimension, $message->getCode());
        if (!$product) {
            $product = $this->productRepository->create($dimension, $message->getCode());
        }

        $this->synchronizeVariants($message->getVariants(), $product);

        return $product;
    }

    /**
     * @param ProductVariantValueObject[] $variantDTOs
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
