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

use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Exception\ProductInformationNotFoundException;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Exception\ProductNotFoundException;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\RemoveProductMessage;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInformationRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductVariantRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductVariantInformationRepositoryInterface;

class RemoveProductMessageHandler
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var ProductInformationRepositoryInterface
     */
    private $productInformationRepository;

    /**
     * @var ProductVariantRepositoryInterface
     */
    private $productVariantRepository;

    /**
     * @var ProductVariantInformationRepositoryInterface
     */
    private $productVariantInformationRepository;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        ProductInformationRepositoryInterface $productInformationRepository,
        ProductVariantRepositoryInterface $productVariantRepository,
        ProductVariantInformationRepositoryInterface $productVariantInformationRepository
    ) {
        $this->productRepository = $productRepository;
        $this->productInformationRepository = $productInformationRepository;
        $this->productVariantRepository = $productVariantRepository;
        $this->productVariantInformationRepository = $productVariantInformationRepository;
    }

    public function __invoke(RemoveProductMessage $message): void
    {
        $product = $this->productRepository->findByCode($message->getCode());

        if (!$product) {
            throw new ProductNotFoundException($message->getCode());
        }

        $variant = $this->productVariantRepository->findByCode($message->getCode());

        if (null !== $variant) {
            $variantInformations = $this->productVariantInformationRepository->findAllByVariantId($variant->getId());

            foreach ($variantInformations as $variantInformation) {
                $this->productVariantInformationRepository->remove($variantInformation);
            }

            $this->productVariantRepository->remove($variant);
        }

        $productInformations = $this->productInformationRepository->findAllByProductId($product->getId());

        foreach ($productInformations as $productInformation) {
            $this->productInformationRepository->remove($productInformation);
        }

        $this->productRepository->remove($product);
    }
}
