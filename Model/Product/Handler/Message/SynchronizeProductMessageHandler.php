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
use Sulu\Bundle\SyliusConsumerBundle\Model\Media\MediaFactory;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductMediaReference;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\ProductImageValueObject;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\ProductTranslationValueObject;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\SynchronizeProductMessage;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInformationRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductMediaReferenceRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductRepositoryInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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

    public function __construct(
        ProductRepositoryInterface $productRepository,
        ProductInformationRepositoryInterface $productInformationRepository,
        DimensionRepositoryInterface $dimensionRepository,
        ProductMediaReferenceRepositoryInterface $productMediaReferenceRepository,
        MediaFactory $mediaFactory,
        Filesystem $filesystem
    ) {
        $this->productRepository = $productRepository;
        $this->productInformationRepository = $productInformationRepository;
        $this->dimensionRepository = $dimensionRepository;
        $this->productMediaReferenceRepository = $productMediaReferenceRepository;
        $this->mediaFactory = $mediaFactory;
        $this->filesystem = $filesystem;
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
            $mediaReference = $this->productMediaReferenceRepository->findBySyliusId($imageValueObject->getId());

            if ($mediaReference) {
                $mediaReference->setSorting($sorting);
                $sorting++;

                continue;
            }

            $addedMediaReference = $this->synchronizeImage($imageValueObject, $product);

            if (!$addedMediaReference) {
                continue;
            }

            $addedMediaReference->setSorting($sorting);
            $sorting++;
        }
    }

    protected function synchronizeImage(ProductImageValueObject $imageValueObject, ProductInterface $product): ?ProductMediaReference {
        // load image
        try {
            $fileContents = file_get_contents('http://sylius.localhost/media/image/' . $imageValueObject->getPath());
        } catch (\Exception $exception) {
            // TODO: Write at least a log entry
            return null;
        }

        // create temp file
        $filename = $this->filesystem->tempnam(sys_get_temp_dir(), 'sylius_import');
        $this->filesystem->dumpFile($filename, $fileContents);
        $file = new File($filename);

        // create sulu media
        $media = $this->mediaFactory->create($file, 'sylius', $product->getCode() . '-'. $imageValueObject->getId(), 'de');

        // delete temp file
        $this->filesystem->remove($filename);

        return $this->productMediaReferenceRepository->create($product, $media, $imageValueObject->getType(), $imageValueObject->getId());
    }
}
