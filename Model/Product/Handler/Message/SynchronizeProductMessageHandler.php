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
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\SynchronizeProductMessage;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInformationRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;
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
     * @var DimensionRepositoryInterface
     */
    private $dimensionRepository;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        ProductInformationRepositoryInterface $productInformationRepository,
        DimensionRepositoryInterface $dimensionRepository
    ) {
        $this->productRepository = $productRepository;
        $this->productInformationRepository = $productInformationRepository;
        $this->dimensionRepository = $dimensionRepository;
    }

    public function __invoke(SynchronizeProductMessage $message): ProductInterface
    {
        $product = $this->productRepository->findByCode($message->getCode());
        if (!$product) {
            $product = $this->productRepository->create($message->getCode());
        }

        $this->synchronizeProduct($message, $product);

        return $product;
    }

    protected function synchronizeProduct(SynchronizeProductMessage $message, ProductInterface $product): void
    {
        foreach ($message->getTranslations() as $translation) {
            $this->synchronizeTranslation($translation, $product);
        }
    }

    protected function synchronizeTranslation(
        ProductTranslationValueObject $translationValueObject,
        ProductInterface $product
    ): void {
        $dimension = $this->dimensionRepository->findOrCreateByAttributes(
            [
                DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_DRAFT,
                DimensionInterface::ATTRIBUTE_KEY_LOCALE => $translationValueObject->getLocale(),
            ]
        );

        $productInformation = $this->productInformationRepository->findByProductId($product->getId(), $dimension);
        if (!$productInformation) {
            $productInformation = $this->productInformationRepository->create($product, $dimension);
        }

        $productInformation->setName($translationValueObject->getName());
        $productInformation->setSlug($translationValueObject->getSlug());
        $productInformation->setDescription($translationValueObject->getDescription());
        $productInformation->setMetaKeywords($translationValueObject->getMetaKeywords());
        $productInformation->setMetaDescription($translationValueObject->getMetaDescription());
        $productInformation->setShortDescription($translationValueObject->getShortDescription());
        $productInformation->setUnit($translationValueObject->getUnit());
        $productInformation->setMarketingText($translationValueObject->getMarketingText());
    }
}
