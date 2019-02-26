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
use GuzzleHttp\Exception\ClientException;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Sulu\Bundle\SyliusConsumerBundle\Model\Category\CategoryRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Media\Factory\MediaFactory;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\PublishProductMessage;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\SynchronizeProductMessage;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\SynchronizeProductVariantMessage;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\ValueObject\ProductAttributeValueValueObject;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\ValueObject\ProductImageValueObject;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\ValueObject\ProductTaxonValueObject;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\ValueObject\ProductTranslationValueObject;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInformationAttributeValueRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInformationInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInformationRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductMediaReference;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductMediaReferenceRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductRepositoryInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Messenger\MessageBusInterface;

class SynchronizeProductMessageHandler
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var MessageBusInterface
     */
    private $messageBus;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var ProductInformationRepositoryInterface
     */
    private $productInformationRepository;

    /**
     * @var ProductInformationAttributeValueRepositoryInterface
     */
    private $productInformationAttributeValueRepository;

    /**
     * @var DimensionRepositoryInterface
     */
    private $dimensionRepository;

    /**
     * @var ProductMediaReferenceRepositoryInterface
     */
    private $productMediaReferenceRepository;

    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepository;

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

    /**
     * @var bool
     */
    private $autoPublish;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        ClientInterface $client,
        MessageBusInterface $messageBus,
        ProductRepositoryInterface $productRepository,
        ProductInformationRepositoryInterface $productInformationRepository,
        ProductInformationAttributeValueRepositoryInterface $productInformationAttributeValueRepository,
        DimensionRepositoryInterface $dimensionRepository,
        ProductMediaReferenceRepositoryInterface $productMediaReferenceRepository,
        CategoryRepositoryInterface $categoryRepository,
        MediaFactory $mediaFactory,
        Filesystem $filesystem,
        string $syliusBaseUrl,
        bool $autoPublish,
        ?LoggerInterface $logger = null
    ) {
        $this->client = $client;
        $this->messageBus = $messageBus;
        $this->productRepository = $productRepository;
        $this->productInformationRepository = $productInformationRepository;
        $this->productInformationAttributeValueRepository = $productInformationAttributeValueRepository;
        $this->dimensionRepository = $dimensionRepository;
        $this->productMediaReferenceRepository = $productMediaReferenceRepository;
        $this->categoryRepository = $categoryRepository;
        $this->mediaFactory = $mediaFactory;
        $this->filesystem = $filesystem;
        $this->syliusBaseUrl = $syliusBaseUrl;
        $this->autoPublish = $autoPublish;
        $this->logger = $logger ?: new NullLogger();
    }

    public function __invoke(SynchronizeProductMessage $message): ProductInterface
    {
        $product = $this->productRepository->findByCode($message->getCode());
        if (!$product) {
            $product = $this->productRepository->create($message->getCode());
        }

        $this->synchronizeProduct($message, $product);
        $this->publishProduct($message, $product);

        return $product;
    }

    protected function publishProduct(SynchronizeProductMessage $message, ProductInterface $product): void
    {
        if (!$this->autoPublish) {
            return;
        }

        foreach ($message->getTranslations() as $translationValueObject) {
            $this->messageBus->dispatch(
                new PublishProductMessage($product->getId(), $translationValueObject->getLocale())
            );
        }
    }

    protected function synchronizeProduct(SynchronizeProductMessage $message, ProductInterface $product): void
    {
        $product->setEnabled($message->getEnabled());
        $product->setCustomData($message->getCustomData());
        $this->synchronizeTranslations($message, $product);
        $this->synchronizeMainTaxon($message, $product);
        $this->synchronizeProductTaxons($message, $product);
        $this->synchronizeImages($message, $product);

        foreach ($message->getVariants() as $variantPayload) {
            $this->messageBus->dispatch(
                new SynchronizeProductVariantMessage(
                    $product->getCode(),
                    $variantPayload['code'],
                    $variantPayload
                )
            );
        }
    }

    protected function synchronizeTranslations(SynchronizeProductMessage $message, ProductInterface $product): void
    {
        foreach ($message->getTranslations() as $translationValueObject) {
            $locale = $translationValueObject->getLocale();

            $dimensionDraft = $this->dimensionRepository->findOrCreateByAttributes(
                [
                    DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_DRAFT,
                    DimensionInterface::ATTRIBUTE_KEY_LOCALE => $locale,
                ]
            );
            $dimensionLive = $this->dimensionRepository->findOrCreateByAttributes(
                [
                    DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_LIVE,
                    DimensionInterface::ATTRIBUTE_KEY_LOCALE => $locale,
                ]
            );

            $attributeValueValueObjects = $message->getAttributeValues($translationValueObject->getLocale());

            $this->synchronizeTranslation(
                $translationValueObject,
                $attributeValueValueObjects,
                $product,
                $dimensionDraft,
                true
            );
            $this->synchronizeTranslation(
                $translationValueObject,
                $attributeValueValueObjects,
                $product,
                $dimensionLive,
                false
            );
        }
    }

    /**
     * @param ProductAttributeValueValueObject[] $attributeValueValueObjects
     */
    protected function synchronizeTranslation(
        ProductTranslationValueObject $translationValueObject,
        array $attributeValueValueObjects,
        ProductInterface $product,
        DimensionInterface $dimension,
        bool $createNotExisting
    ): void {
        $productInformation = $this->productInformationRepository->findByProductId($product->getId(), $dimension);
        if (!$productInformation && $createNotExisting) {
            $productInformation = $this->productInformationRepository->create($product, $dimension);
        }

        if (!$productInformation) {
            return;
        }

        $productInformation->setName($translationValueObject->getName());
        $productInformation->setSlug($translationValueObject->getSlug());
        $productInformation->setDescription($translationValueObject->getDescription());
        $productInformation->setMetaKeywords($translationValueObject->getMetaKeywords());
        $productInformation->setMetaDescription($translationValueObject->getMetaDescription());
        $productInformation->setShortDescription($translationValueObject->getShortDescription());
        $productInformation->setCustomData($translationValueObject->getCustomData());

        $this->synchronizeAttributeValues($attributeValueValueObjects, $productInformation);
    }

    /**
     * @param ProductAttributeValueValueObject[] $attributeValueValueObjects
     */
    protected function synchronizeAttributeValues(
        array $attributeValueValueObjects,
        ProductInformationInterface $productInformation
    ): void {
        // process existing and new
        $processedAttributeValueCodes = [];
        foreach ($attributeValueValueObjects as $attributeValueValueObject) {
            $this->synchronizeAttributeValue($attributeValueValueObject, $productInformation);
            $processedAttributeValueCodes[] = $attributeValueValueObject->getCode();
        }

        // check for removed
        foreach (array_diff($productInformation->getAttributeValueCodes(), $processedAttributeValueCodes) as $attributeValueCode) {
            $productInformation->removeAttributeValueByCode($attributeValueCode);
        }
    }

    protected function synchronizeAttributeValue(
        ProductAttributeValueValueObject $attributeValueValueObject,
        ProductInformationInterface $productInformation
    ): void {
        $code = $attributeValueValueObject->getCode();

        $attributeValue = $productInformation->findAttributeValueByCode($code);
        if (!$attributeValue) {
            // create new one
            $attributeValue = $this->productInformationAttributeValueRepository->create(
                $productInformation,
                $code,
                $attributeValueValueObject->getType()
            );
        }

        $attributeValue->setValue($attributeValueValueObject->getAttributeValue());
    }

    protected function synchronizeMainTaxon(SynchronizeProductMessage $message, ProductInterface $product): void
    {
        $mainCategory = null;
        $mainTaxonId = $message->getmainTaxonId();
        if ($mainTaxonId) {
            $mainCategory = $this->categoryRepository->findBySyliusId($mainTaxonId);
        }
        $product->setMainCategory($mainCategory);
    }

    protected function synchronizeProductTaxons(SynchronizeProductMessage $message, ProductInterface $product): void
    {
        $currentCategories = $product->getProductCategories();
        $processedTaxonIds = [];

        // check for new added
        foreach ($message->getProductTaxons() as $productTaxonValueObject) {
            $this->synchronizeProductTaxon($productTaxonValueObject, $product);
            $processedTaxonIds[] = $productTaxonValueObject->getTaxonId();
        }

        // check for removed
        foreach ($currentCategories as $category) {
            if (in_array($category->getSyliusId(), $processedTaxonIds)) {
                continue;
            }

            $product->removeProductCategory($category);
        }
    }

    protected function synchronizeProductTaxon(
        ProductTaxonValueObject $productTaxonValueObject,
        ProductInterface $product
    ): void {
        if ($product->findProductCategoryBySyliusId($productTaxonValueObject->getTaxonId())) {
            return;
        }

        $category = $this->categoryRepository->findBySyliusId($productTaxonValueObject->getTaxonId());
        if (!$category) {
            // TODO: Write at least log entry
            return;
        }

        $product->addProductCategory($category);
    }

    protected function synchronizeImages(SynchronizeProductMessage $message, ProductInterface $product): void
    {
        $currentMediaReferences = $product->getMediaReferences();

        // sync existing and new one
        $processedImageIds = [];
        foreach ($message->getImages() as $imageValueObject) {
            $this->synchronizeImage($imageValueObject, $product);
            $processedImageIds[] = $imageValueObject->getId();
        }

        // check for removed
        foreach ($currentMediaReferences as $mediaReference) {
            if (!$mediaReference->getSyliusId()) {
                continue;
            }

            if (in_array($mediaReference->getSyliusId(), $processedImageIds)) {
                continue;
            }

            $product->removeMediaReference($mediaReference);
        }
    }

    protected function synchronizeImage(
        ProductImageValueObject $imageValueObject,
        ProductInterface $product
    ): void {
        $mediaReference = $this->productMediaReferenceRepository->findBySyliusId($imageValueObject->getId());

        if (!$mediaReference) {
            $this->createMediaReference($imageValueObject, $product);

            return;
        }

        $mediaReference->setType($imageValueObject->getType());

        if ($mediaReference->getSyliusPath() !== $imageValueObject->getPath()) {
            $this->updateMediaReference($imageValueObject, $product, $mediaReference);

            return;
        }

        $this->mediaFactory->updateTitles($mediaReference->getMedia(), $this->getImageTitles($product));
    }

    protected function createMediaReference(
        ProductImageValueObject $imageValueObject,
        ProductInterface $product
    ): ?ProductMediaReference {
        // download file from Sylius application
        $file = $this->downloadImage($imageValueObject->getPath());
        if (!$file) {
            return null;
        }

        // create sulu media
        $media = $this->mediaFactory->create(
            $file,
            $imageValueObject->getFilename(),
            'sylius',
            $this->getImageTitles($product)
        );

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

        return $mediaReference;
    }

    protected function updateMediaReference(
        ProductImageValueObject $imageValueObject,
        ProductInterface $product,
        ProductMediaReference $mediaReference
    ): ?ProductMediaReference {
        // download file from Sylius application
        $file = $this->downloadImage($imageValueObject->getPath());
        if (!$file) {
            return null;
        }

        // update sulu media
        $this->mediaFactory->update(
            $mediaReference->getMedia(),
            $file,
            $imageValueObject->getFilename(),
            $this->getImageTitles($product)
        );

        // delete temp file
        $this->filesystem->remove($file->getPathname());

        // save new path
        $mediaReference->setSyliusPath($imageValueObject->getPath());

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

    private function downloadImage(string $path): ?File
    {
        // download the image
        $url = $this->syliusBaseUrl . '/media/image/' . $path;

        try {
            $request = $this->client->request('GET', $url);
        } catch (ClientException $exception) {
            if (404 === $exception->getCode()) {
                $this->logger->error('Could not download image from "' . $url . '"');

                return null;
            }

            throw $exception;
        }

        // create temp file
        $tempFilename = $this->filesystem->tempnam(sys_get_temp_dir(), 'sii');

        // create correct filename with extension
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        $filename = str_replace('sii', 'sylius-', $tempFilename) . '.' . $extension;

        // rename the temp file to the correct one
        $this->filesystem->rename($tempFilename, $filename);

        // save file to the system
        $this->filesystem->dumpFile($filename, $request->getBody()->getContents());
        $file = new File($filename);

        return $file;
    }
}
