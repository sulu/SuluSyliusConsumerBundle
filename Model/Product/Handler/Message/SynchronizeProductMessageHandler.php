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

use GuzzleHttp\ClientInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Media\Factory\MediaFactory;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\ProductImageValueObject;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\ProductTranslationValueObject;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\SynchronizeProductMessage;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInformationRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductMediaReference;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductMediaReferenceRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductRepositoryInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;

class SynchronizeProductMessageHandler
{
    /**
     * @var ClientInterface
     */
    private $client;

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
     * @var ProductMediaReferenceRepositoryInterface
     */
    private $productMediaReferenceRepository;

    /**
     * @var MediaFactory
     */
    private $mediaFactory;

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var string
     */
    private $syliusBaseUrl;

    public function __construct(
        ClientInterface $client,
        ProductRepositoryInterface $productRepository,
        ProductInformationRepositoryInterface $productInformationRepository,
        DimensionRepositoryInterface $dimensionRepository,
        ProductMediaReferenceRepositoryInterface $productMediaReferenceRepository,
        MediaFactory $mediaFactory,
        Filesystem $filesystem,
        string $syliusBaseUrl
    ) {
        $this->client = $client;
        $this->productRepository = $productRepository;
        $this->productInformationRepository = $productInformationRepository;
        $this->dimensionRepository = $dimensionRepository;
        $this->productMediaReferenceRepository = $productMediaReferenceRepository;
        $this->mediaFactory = $mediaFactory;
        $this->filesystem = $filesystem;
        $this->syliusBaseUrl = $syliusBaseUrl;
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
        $this->synchronizeTranslations($message, $product);
        $this->synchronizeImages($message, $product);
    }

    protected function synchronizeTranslations(SynchronizeProductMessage $message, ProductInterface $product): void
    {
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

            $this->synchronizeTranslation($translationValueObject, $product, $dimensionDraft);
            $this->synchronizeTranslation($translationValueObject, $product, $dimensionLive);
        }
    }

    protected function synchronizeTranslation(
        ProductTranslationValueObject $translationValueObject,
        ProductInterface $product,
        DimensionInterface $dimension
    ): void {
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
    }

    protected function synchronizeImages(SynchronizeProductMessage $message, ProductInterface $product): void
    {
        $sorting = 1;
        foreach ($message->getImages() as $imageValueObject) {
            $this->synchronizeImage($imageValueObject, $product, $sorting);
            ++$sorting;
        }
    }

    protected function synchronizeImage(
        ProductImageValueObject $imageValueObject,
        ProductInterface $product,
        int $sorting
    ): void {
        $mediaReference = $this->productMediaReferenceRepository->findBySyliusId($imageValueObject->getId());

        if (!$mediaReference) {
            $this->createMediaReference($imageValueObject, $product, $sorting);

            return;
        }

        if ($mediaReference->getSyliusPath() !== $imageValueObject->getPath()) {
            $this->updateMediaReference($imageValueObject, $product, $mediaReference, $sorting);

            return;
        }

        $this->mediaFactory->updateTitles($mediaReference->getMedia(), $this->getImageTitles($product));
    }

    protected function createMediaReference(
        ProductImageValueObject $imageValueObject,
        ProductInterface $product,
        int $sorting
    ): ?ProductMediaReference {
        // download file from Sylius application
        $file = $this->downloadImage($imageValueObject->getPath());

        // create sulu media
        $media = $this->mediaFactory->create($file, 'sylius', $this->getImageTitles($product));

        // delete temp file
        $this->filesystem->remove($file->getPathname());

        // create product media reference
        $mediaReference = $this->productMediaReferenceRepository->create(
            $product,
            $media,
            $imageValueObject->getType(),
            $imageValueObject->getId()
        );

        // save path
        $mediaReference->setSyliusPath($imageValueObject->getPath());
        $mediaReference->setSorting($sorting);

        return $mediaReference;
    }

    protected function updateMediaReference(
        ProductImageValueObject $imageValueObject,
        ProductInterface $product,
        ProductMediaReference $mediaReference,
        int $sorting
    ): ?ProductMediaReference {
        // download file from Sylius application
        $file = $this->downloadImage($imageValueObject->getPath());

        // update sulu media
        $this->mediaFactory->update($mediaReference->getMedia(), $file, $this->getImageTitles($product));

        // delete temp file
        $this->filesystem->remove($file->getPathname());

        // save new path
        $mediaReference->setSyliusPath($imageValueObject->getPath());
        $mediaReference->setSorting($sorting);

        return $mediaReference;
    }

    protected function getImageTitles(ProductInterface $product): array
    {
        $titles = [];
        foreach ($product->getProductInformations() as $productInformation) {
            if ($productInformation->getDimension()->hasAttribute(DimensionInterface::ATTRIBUTE_KEY_LOCALE)) {
                $locale = $productInformation->getDimension()->getAttributeValue(DimensionInterface::ATTRIBUTE_KEY_LOCALE);
                $titles[$locale] = $productInformation->getName();
            }
        }

        return $titles;
    }

    private function downloadImage(string $path): File
    {
        // download the image
        $url = $this->syliusBaseUrl . '/media/image/' . $path;
        $request = $this->client->request('GET', $url);

        // create temp file
        $filename = $this->filesystem->tempnam(sys_get_temp_dir(), 'sii');
        $this->filesystem->dumpFile($filename, $request->getBody()->getContents());
        $file = new File($filename);

        return $file;
    }
}
