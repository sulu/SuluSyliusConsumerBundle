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

use Sulu\Bundle\SyliusConsumerBundle\Model\Content\Message\PublishContentMessage;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Exception\ProductInformationNotFoundException;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Exception\ProductNotFoundException;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\PublishProductMessage;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\PublishProductVariantMessage;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInformationRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\RoutableResource\Message\PublishRoutableResourceMessage;
use Symfony\Cmf\Api\Slugifier\SlugifierInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class PublishProductMessageHandler
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

    /**
     * @var MessageBusInterface
     */
    private $messageBus;

    /**
     * @var SlugifierInterface
     */
    private $slugifier;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        ProductInformationRepositoryInterface $productInformationRepository,
        DimensionRepositoryInterface $dimensionRepository,
        MessageBusInterface $messageBus,
        SlugifierInterface $slugifier
    ) {
        $this->productRepository = $productRepository;
        $this->productInformationRepository = $productInformationRepository;
        $this->dimensionRepository = $dimensionRepository;
        $this->messageBus = $messageBus;
        $this->slugifier = $slugifier;
    }

    public function __invoke(PublishProductMessage $message): ProductInterface
    {
        $product = $this->productRepository->findById($message->getId());
        if (!$product) {
            throw new ProductNotFoundException($message->getId());
        }

        try {
            $this->publishProductInformation($product, $message->getLocale());
        } catch (ProductInformationNotFoundException $exception) {
            throw new ProductNotFoundException($message->getId(), 0, $exception);
        }

        $this->messageBus->dispatch(
            new PublishContentMessage(ProductInterface::RESOURCE_KEY, $message->getId(), $message->getLocale())
        );

        // FIXME generate route by-schema
        $routePath = '/products/' . $this->slugifier->slugify($product->getCode());
        $this->messageBus->dispatch(
            new PublishRoutableResourceMessage(
                ProductInterface::RESOURCE_KEY, $message->getId(),
                $message->getLocale(),
                $routePath
            )
        );

        foreach ($product->getVariants() as $variant) {
            $this->messageBus->dispatch(new PublishProductVariantMessage($variant->getId(), $message->getLocale()));
        }

        return $product;
    }

    private function publishProductInformation(ProductInterface $product, string $locale): void
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

        $draftProductInformation = $this->productInformationRepository->findByProductId(
            $product->getId(),
            $draftDimension
        );
        if (!$draftProductInformation) {
            throw new ProductInformationNotFoundException($product->getId());
        }

        $liveProductInformation = $this->productInformationRepository->findByProductId(
            $product->getId(),
            $liveDimension
        );
        if (!$liveProductInformation) {
            $liveProductInformation = $this->productInformationRepository->create($product, $liveDimension);
        }

        $liveProductInformation->mapPublishProperties($draftProductInformation);
    }
}
