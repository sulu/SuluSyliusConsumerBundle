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

use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\ProductTranslationValueObject;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\ProductVariantValueObject;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\SynchronizeProductMessage;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInformationInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInformationRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInformationVariantRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductRepositoryInterface;

class SynchronizeProductMessageHandler
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
     * @var ProductInformationVariantRepositoryInterface
     */
    private $variantRepository;

    /**
     * @var DimensionRepositoryInterface
     */
    private $dimensionRepository;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        ProductInformationRepositoryInterface $productInformationRepository,
        ProductInformationVariantRepositoryInterface $variantRepository,
        DimensionRepositoryInterface $dimensionRepository
    ) {
        $this->productRepository = $productRepository;
        $this->productInformationRepository = $productInformationRepository;
        $this->variantRepository = $variantRepository;
        $this->dimensionRepository = $dimensionRepository;
    }

    public function __invoke(SynchronizeProductMessage $message): void
    {
        $this->productRepository->create($message->getCode());

        foreach ($message->getTranslations() as $translation) {
            $this->synchronizeProduct($message, $translation);
        }
    }

    private function synchronizeProduct(
        SynchronizeProductMessage $message,
        ProductTranslationValueObject $translationValueObject
    ): void {
        $dimension = $this->dimensionRepository->findOrCreateByAttributes(
            [
                DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_DRAFT,
                DimensionInterface::ATTRIBUTE_KEY_LOCALE => $translationValueObject->getLocale(),
            ]
        );

        $product = $this->productInformationRepository->findByCode($message->getCode(), $dimension);
        if (!$product) {
            $product = $this->productInformationRepository->create($message->getCode(), $dimension);
        }

        $product->setName($translationValueObject->getName());

        $this->synchronizeVariants($message->getVariants(), $product, $translationValueObject->getLocale());
    }

    /**
     * @param ProductVariantValueObject[] $variantValueObjects
     */
    private function synchronizeVariants(array $variantValueObjects, ProductInformationInterface $product, string $locale): void
    {
        $codes = [];
        foreach ($variantValueObjects as $variantValueObject) {
            $variant = $product->findVariantByCode($variantValueObject->getCode());
            if (!$variant) {
                $variant = $this->variantRepository->create($product, $variantValueObject->getCode());
            }

            $variantTranslationValueObject = $variantValueObject->findTranslationByLocale($locale);
            if ($variantTranslationValueObject) {
                $variant->setName($variantTranslationValueObject->getName());
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
