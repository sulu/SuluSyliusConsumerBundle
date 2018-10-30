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

namespace Sulu\Bundle\SyliusConsumerBundle\Tests\Unit\Model\Product\Handler\Message;

use GuzzleHttp\ClientInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Sulu\Bundle\MediaBundle\Entity\MediaInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Media\MediaFactory;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Handler\Message\SynchronizeProductMessageHandler;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\ProductImageValueObject;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\ProductTranslationValueObject;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\SynchronizeProductMessage;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInformationInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInformationRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductMediaReference;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Repository\Product\ProductMediaReferenceRepository;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;

class SynchronizeProductMessageHandlerTest extends TestCase
{
    public function testInvokeCreate(): void
    {
        $productTranslationValueObject = $this->prophesize(ProductTranslationValueObject::class);
        $productTranslationValueObject->getLocale()->willReturn('de');
        $productTranslationValueObject->getName()->willReturn('Product One');
        $productTranslationValueObject->getSlug()->willReturn('/nice-slug');
        $productTranslationValueObject->getDescription()->willReturn('Very nice description! Yes!');
        $productTranslationValueObject->getShortDescription()->willReturn('Nice, but short!');
        $productTranslationValueObject->getMetaKeywords()->willReturn('123, 123, 123');
        $productTranslationValueObject->getMetaDescription()->willReturn('Meta description..');

        $productImageValueObject = $this->prophesize(ProductImageValueObject::class);
        $productImageValueObject->getId()->willReturn(27);
        $productImageValueObject->getPath()->willReturn('ab/12/test1.png');
        $productImageValueObject->getType()->willReturn('test_type');

        $message = $this->prophesize(SynchronizeProductMessage::class);
        $message->getCode()->willReturn('product-1');
        $message->getTranslations()->willReturn([$productTranslationValueObject->reveal()]);
        $message->getImages()->willReturn([$productImageValueObject->reveal()]);

        $client = $this->prophesize(ClientInterface::class);
        $productRepository = $this->prophesize(ProductRepositoryInterface::class);
        $productInformationRepository = $this->prophesize(ProductInformationRepositoryInterface::class);
        $dimensionRepository = $this->prophesize(DimensionRepositoryInterface::class);
        $productMediaReferenceRepository = $this->prophesize(ProductMediaReferenceRepository::class);
        $mediaFactory = $this->prophesize(MediaFactory::class);
        $filesystem = $this->prophesize(Filesystem::class);

        $handler = new SynchronizeProductMessageHandler(
            $client->reveal(),
            $productRepository->reveal(),
            $productInformationRepository->reveal(),
            $dimensionRepository->reveal(),
            $productMediaReferenceRepository->reveal(),
            $mediaFactory->reveal(),
            $filesystem->reveal(),
            'http://sylius.localhost'
        );

        $product = $this->prophesize(ProductInterface::class);
        $product->getId()->willReturn('123-123-123');

        $productRepository->findByCode('product-1')->willReturn(null)->shouldBeCalled();
        $productRepository->create('product-1')->willReturn($product->reveal())->shouldBeCalled();

        $dimensionDraft = $this->prophesize(DimensionInterface::class);
        $dimensionDraft->hasAttribute(DimensionInterface::ATTRIBUTE_KEY_LOCALE)->willReturn(true);
        $dimensionDraft->getAttributeValue(DimensionInterface::ATTRIBUTE_KEY_LOCALE)->willReturn('de');

        $dimensionLive = $this->prophesize(DimensionInterface::class);
        $dimensionLive->hasAttribute(DimensionInterface::ATTRIBUTE_KEY_LOCALE)->willReturn(true);
        $dimensionLive->getAttributeValue(DimensionInterface::ATTRIBUTE_KEY_LOCALE)->willReturn('de');

        $dimensionRepository->findOrCreateByAttributes(
            [
                DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_DRAFT,
                DimensionInterface::ATTRIBUTE_KEY_LOCALE => 'de',
            ]
        )->willReturn($dimensionDraft->reveal());
        $dimensionRepository->findOrCreateByAttributes(
            [
                DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_LIVE,
                DimensionInterface::ATTRIBUTE_KEY_LOCALE => 'de',
            ]
        )->willReturn($dimensionLive->reveal());

        $productInformationRepository->findByProductId('123-123-123', $dimensionDraft->reveal())->willReturn(null);
        $productInformationDraft = $this->prophesize(ProductInformationInterface::class);
        $productInformationDraft->getDimension()->willReturn($dimensionDraft);
        $productInformationDraft->setName('Product One')->shouldBeCalled()->willReturn($productInformationDraft->reveal());
        $productInformationDraft->getName()->shouldBeCalled()->willReturn('Product One');
        $productInformationDraft->setSlug('/nice-slug')->shouldBeCalled()->willReturn($productInformationDraft->reveal());
        $productInformationDraft->setDescription('Very nice description! Yes!')->shouldBeCalled()->willReturn($productInformationDraft->reveal());
        $productInformationDraft->setMetaKeywords('123, 123, 123')->shouldBeCalled()->willReturn($productInformationDraft->reveal());
        $productInformationDraft->setMetaDescription('Meta description..')->shouldBeCalled()->willReturn($productInformationDraft->reveal());
        $productInformationDraft->setShortDescription('Nice, but short!')->shouldBeCalled()->willReturn($productInformationDraft->reveal());
        $productInformationRepository->create($product->reveal(), $dimensionDraft->reveal())
            ->shouldBeCalled()
            ->willReturn($productInformationDraft->reveal());

        $productInformationRepository->findByProductId('123-123-123', $dimensionLive->reveal())->willReturn(null);
        $productInformationLive = $this->prophesize(ProductInformationInterface::class);
        $productInformationLive->getDimension()->willReturn($dimensionLive);
        $productInformationLive->setName('Product One')->shouldBeCalled()->willReturn($productInformationLive->reveal());
        $productInformationLive->getName()->shouldBeCalled()->willReturn('Product One');
        $productInformationLive->setSlug('/nice-slug')->shouldBeCalled()->willReturn($productInformationLive->reveal());
        $productInformationLive->setDescription('Very nice description! Yes!')->shouldBeCalled()->willReturn($productInformationLive->reveal());
        $productInformationLive->setMetaKeywords('123, 123, 123')->shouldBeCalled()->willReturn($productInformationLive->reveal());
        $productInformationLive->setMetaDescription('Meta description..')->shouldBeCalled()->willReturn($productInformationLive->reveal());
        $productInformationLive->setShortDescription('Nice, but short!')->shouldBeCalled()->willReturn($productInformationLive->reveal());
        $productInformationRepository->create($product->reveal(), $dimensionLive->reveal())
            ->shouldBeCalled()
            ->willReturn($productInformationLive->reveal());

        $product->getProductInformations()->willReturn([$productInformationDraft->reveal(), $productInformationLive->reveal()]);

        $stream1 = $this->prophesize(StreamInterface::class);
        $stream1->getContents()->willReturn('image-content-1');
        $reponse1 = $this->prophesize(ResponseInterface::class);
        $reponse1->getBody()->willReturn($stream1->reveal());
        $client->request('GET', 'http://sylius.localhost/media/image/ab/12/test1.png')->willReturn($reponse1->reveal());

        $filesystem->tempnam(Argument::any(), 'sii')->willReturn(__DIR__ . '/images/test.png');
        $filesystem->dumpFile(__DIR__ . '/images/test.png', 'image-content-1')->willReturn();
        $filesystem->remove(__DIR__ . '/images/test.png')->shouldBeCalled();

        $media = $this->prophesize(MediaInterface::class);
        $mediaFactory->create(Argument::type(File::class), 'sylius', ['de' => 'Product One'])
            ->willReturn($media->reveal());

        $productMediaReference = $this->prophesize(ProductMediaReference::class);
        $productMediaReference->setSyliusPath('ab/12/test1.png')->willReturn($productMediaReference->reveal());
        $productMediaReference->setSorting(1)->willReturn($productMediaReference->reveal());
        $productMediaReferenceRepository->findBySyliusId(27)->willReturn(null);
        $productMediaReferenceRepository->create($product->reveal(), $media->reveal(), 'test_type', 27)
            ->willReturn($productMediaReference->reveal());

        $handler->__invoke($message->reveal());
    }

    public function testInvokeUpdate(): void
    {
        $productTranslationValueObject = $this->prophesize(ProductTranslationValueObject::class);
        $productTranslationValueObject->getLocale()->willReturn('de');
        $productTranslationValueObject->getName()->willReturn('Product One');
        $productTranslationValueObject->getSlug()->willReturn('/nice-slug');
        $productTranslationValueObject->getDescription()->willReturn('Very nice description! Yes!');
        $productTranslationValueObject->getShortDescription()->willReturn('Nice, but short!');
        $productTranslationValueObject->getMetaKeywords()->willReturn('123, 123, 123');
        $productTranslationValueObject->getMetaDescription()->willReturn('Meta description..');

        $productImageValueObject = $this->prophesize(ProductImageValueObject::class);
        $productImageValueObject->getId()->willReturn(27);
        $productImageValueObject->getPath()->willReturn('ab/12/test1.png');
        $productImageValueObject->getType()->willReturn('test_type');

        $message = $this->prophesize(SynchronizeProductMessage::class);
        $message->getCode()->willReturn('product-1');
        $message->getTranslations()->willReturn([$productTranslationValueObject->reveal()]);
        $message->getImages()->willReturn([$productImageValueObject->reveal()]);

        $client = $this->prophesize(ClientInterface::class);
        $productRepository = $this->prophesize(ProductRepositoryInterface::class);
        $productInformationRepository = $this->prophesize(ProductInformationRepositoryInterface::class);
        $dimensionRepository = $this->prophesize(DimensionRepositoryInterface::class);
        $productMediaReferenceRepository = $this->prophesize(ProductMediaReferenceRepository::class);
        $mediaFactory = $this->prophesize(MediaFactory::class);
        $filesystem = $this->prophesize(Filesystem::class);

        $handler = new SynchronizeProductMessageHandler(
            $client->reveal(),
            $productRepository->reveal(),
            $productInformationRepository->reveal(),
            $dimensionRepository->reveal(),
            $productMediaReferenceRepository->reveal(),
            $mediaFactory->reveal(),
            $filesystem->reveal(),
            'http://sylius.localhost'
        );

        $product = $this->prophesize(ProductInterface::class);
        $product->getId()->willReturn('123-123-123');
        $productRepository->findByCode('product-1')->willReturn($product->reveal())->shouldBeCalled();

        $dimensionDraft = $this->prophesize(DimensionInterface::class);
        $dimensionDraft->hasAttribute(DimensionInterface::ATTRIBUTE_KEY_LOCALE)->willReturn(true);
        $dimensionDraft->getAttributeValue(DimensionInterface::ATTRIBUTE_KEY_LOCALE)->willReturn('de');

        $dimensionLive = $this->prophesize(DimensionInterface::class);
        $dimensionLive->hasAttribute(DimensionInterface::ATTRIBUTE_KEY_LOCALE)->willReturn(true);
        $dimensionLive->getAttributeValue(DimensionInterface::ATTRIBUTE_KEY_LOCALE)->willReturn('de');

        $dimensionRepository->findOrCreateByAttributes(
            [
                DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_DRAFT,
                DimensionInterface::ATTRIBUTE_KEY_LOCALE => 'de',
            ]
        )->willReturn($dimensionDraft->reveal());
        $dimensionRepository->findOrCreateByAttributes(
            [
                DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_LIVE,
                DimensionInterface::ATTRIBUTE_KEY_LOCALE => 'de',
            ]
        )->willReturn($dimensionLive->reveal());

        $productInformationDraft = $this->prophesize(ProductInformationInterface::class);
        $productInformationDraft->getDimension()->willReturn($dimensionDraft);
        $productInformationDraft->setName('Product One')->shouldBeCalled()->willReturn($productInformationDraft->reveal());
        $productInformationDraft->getName()->shouldBeCalled()->willReturn('Product One');
        $productInformationDraft->setSlug('/nice-slug')->shouldBeCalled()->willReturn($productInformationDraft->reveal());
        $productInformationDraft->setDescription('Very nice description! Yes!')->shouldBeCalled()->willReturn($productInformationDraft->reveal());
        $productInformationDraft->setMetaKeywords('123, 123, 123')->shouldBeCalled()->willReturn($productInformationDraft->reveal());
        $productInformationDraft->setMetaDescription('Meta description..')->shouldBeCalled()->willReturn($productInformationDraft->reveal());
        $productInformationDraft->setShortDescription('Nice, but short!')->shouldBeCalled()->willReturn($productInformationDraft->reveal());
        $productInformationRepository->findByProductId('123-123-123', $dimensionDraft->reveal())
            ->willReturn($productInformationDraft->reveal());

        $productInformationLive = $this->prophesize(ProductInformationInterface::class);
        $productInformationLive->getDimension()->willReturn($dimensionLive);
        $productInformationLive->setName('Product One')->shouldBeCalled()->willReturn($productInformationLive->reveal());
        $productInformationLive->getName()->shouldBeCalled()->willReturn('Product One');
        $productInformationLive->setSlug('/nice-slug')->shouldBeCalled()->willReturn($productInformationLive->reveal());
        $productInformationLive->setDescription('Very nice description! Yes!')->shouldBeCalled()->willReturn($productInformationLive->reveal());
        $productInformationLive->setMetaKeywords('123, 123, 123')->shouldBeCalled()->willReturn($productInformationLive->reveal());
        $productInformationLive->setMetaDescription('Meta description..')->shouldBeCalled()->willReturn($productInformationLive->reveal());
        $productInformationLive->setShortDescription('Nice, but short!')->shouldBeCalled()->willReturn($productInformationLive->reveal());
        $productInformationRepository->findByProductId('123-123-123', $dimensionLive->reveal())
            ->willReturn($productInformationLive->reveal());

        $product->getProductInformations()->willReturn([$productInformationDraft->reveal(), $productInformationLive->reveal()]);

        $productInformationRepository->create(Argument::cetera())->shouldNotBeCalled();

        $stream1 = $this->prophesize(StreamInterface::class);
        $stream1->getContents()->willReturn('image-content-1');
        $reponse1 = $this->prophesize(ResponseInterface::class);
        $reponse1->getBody()->willReturn($stream1->reveal());
        $client->request('GET', 'http://sylius.localhost/media/image/ab/12/test1.png')->willReturn($reponse1->reveal());

        $filesystem->tempnam(Argument::any(), 'sii')->willReturn(__DIR__ . '/images/test.png');
        $filesystem->dumpFile(__DIR__ . '/images/test.png', 'image-content-1')->willReturn();
        $filesystem->remove(__DIR__ . '/images/test.png')->shouldBeCalled();

        $media = $this->prophesize(MediaInterface::class);
        $mediaFactory->update($media->reveal(), Argument::type(File::class), ['de' => 'Product One'])
            ->willReturn($media->reveal());

        $productMediaReference = $this->prophesize(ProductMediaReference::class);
        $productMediaReference->setSyliusPath('ab/12/test1.png')->willReturn($productMediaReference->reveal());
        $productMediaReference->setSorting(1)->willReturn($productMediaReference->reveal());
        $productMediaReference->getSyliusPath()->willReturn('/old-path');
        $productMediaReference->getMedia()->willReturn($media->reveal());
        $productMediaReferenceRepository->findBySyliusId(27)->willReturn($productMediaReference->reveal());

        $handler->__invoke($message->reveal());
    }
}
