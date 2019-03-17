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
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Exception\ProductVariantInformationNotFoundException;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Exception\ProductVariantNotFoundException;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\PublishProductVariantMessage;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductVariantInformationRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductVariantInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductVariantRepositoryInterface;

class PublishProductVariantMessageHandler
{
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
        ProductVariantRepositoryInterface $productVariantRepository,
        ProductVariantInformationRepositoryInterface $productVariantInformationRepository,
        DimensionRepositoryInterface $dimensionRepository
    ) {
        $this->productVariantRepository = $productVariantRepository;
        $this->productVariantInformationRepository = $productVariantInformationRepository;
        $this->dimensionRepository = $dimensionRepository;
    }

    public function __invoke(PublishProductVariantMessage $message): void
    {
        $productVariant = $this->productVariantRepository->findById($message->getId());
        if (!$productVariant) {
            throw new ProductVariantNotFoundException($message->getId());
        }

        try {
            $this->publishInformation($productVariant, $message->getLocale(), $message->getMandatory());
        } catch (ProductVariantInformationNotFoundException $exception) {
            throw new ProductVariantNotFoundException($message->getId(), 0, $exception);
        }

        $message->setProductVariant($productVariant);
    }

    private function publishInformation(ProductVariantInterface $productVariant, string $locale, bool $mandatory): void
    {
        $draftDimension = $this->dimensionRepository->findOrCreateByAttributes(
            [
                DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_DRAFT,
                DimensionInterface::ATTRIBUTE_KEY_LOCALE => $locale,
            ]
        );
        $liveDimension = $this->dimensionRepository->findOrCreateByAttributes(
            [
                DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_LIVE,
                DimensionInterface::ATTRIBUTE_KEY_LOCALE => $locale,
            ]
        );

        $draftProductVariantInformation = $this->productVariantInformationRepository->findByVariantId(
            $productVariant->getId(),
            $draftDimension
        );
        if (!$draftProductVariantInformation) {
            if (!$mandatory) {
                return;
            }

            throw new ProductVariantInformationNotFoundException($productVariant->getId());
        }

        $liveProductVariantInformation = $this->productVariantInformationRepository->findByVariantId(
            $productVariant->getId(),
            $liveDimension
        );
        if (!$liveProductVariantInformation) {
            $liveProductVariantInformation = $this->productVariantInformationRepository->create(
                $productVariant,
                $liveDimension
            );
        }

        $liveProductVariantInformation->setName($draftProductVariantInformation->getName());
    }
}
