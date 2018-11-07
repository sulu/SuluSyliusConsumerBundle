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
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\SynchronizeProductVariantMessage;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\ValueObject\ProductVariantTranslationValueObject;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductVariantInformationRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductVariantInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductVariantRepositoryInterface;

class SynchronizeProductVariantMessageHandler
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var ProductVariantRepositoryInterface
     */
    private $productVariantRepository;

    /**
     * @var ProductVariantInformationRepositoryInterface
     */
    private $productVariantInformationRepository;

    /**
     * @var DimensionRepositoryInterface
     */
    private $dimensionRepository;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        ProductVariantRepositoryInterface $productionVariantRepository,
        ProductVariantInformationRepositoryInterface $productVariantInformationRepository,
        DimensionRepositoryInterface $dimensionRepository
    ) {
        $this->productRepository = $productRepository;
        $this->productVariantRepository = $productionVariantRepository;
        $this->productVariantInformationRepository = $productVariantInformationRepository;
        $this->dimensionRepository = $dimensionRepository;
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

    protected function synchronizeProductVariant(
        SynchronizeProductVariantMessage $message,
        ProductVariantInterface $productVariant
    ): void {
        $productVariant->setCustomData($productVariant->getCustomData());
        $this->synchronizeTranslations($message, $productVariant);
    }

    protected function synchronizeTranslations(
        SynchronizeProductVariantMessage $message,
        ProductVariantInterface $productVariant
    ): void {
        foreach ($message->getTranslations() as $translationValueObject) {
            $dimensionDraft = $this->dimensionRepository->findOrCreateByAttributes(
                [
                    DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_DRAFT,
                    DimensionInterface::ATTRIBUTE_KEY_LOCALE => $translationValueObject->getLocale(),
                ]
            );
            $dimensionLive = $this->dimensionRepository->findOrCreateByAttributes(
                [
                    DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_LIVE,
                    DimensionInterface::ATTRIBUTE_KEY_LOCALE => $translationValueObject->getLocale(),
                ]
            );

            $this->synchronizeTranslation($translationValueObject, $productVariant, $dimensionDraft);
            $this->synchronizeTranslation($translationValueObject, $productVariant, $dimensionLive);
        }
    }

    protected function synchronizeTranslation(
        ProductVariantTranslationValueObject $translationValueObject,
        ProductVariantInterface $productVariant,
        DimensionInterface $dimension
    ): void {
        $productVariantInformation = $this->productVariantInformationRepository->findByVariantId(
            $productVariant->getId(),
            $dimension
        );
        if (!$productVariantInformation) {
            $productVariantInformation = $this->productVariantInformationRepository->create(
                $productVariant,
                $dimension
            );
        }

        $productVariantInformation->setName($translationValueObject->getName());
        $productVariantInformation->setCustomData($translationValueObject->getCustomData());
    }
}
