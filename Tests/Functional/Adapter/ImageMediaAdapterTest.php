<?php

declare(strict_types=1);

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\SyliusConsumerBundle\Tests\Functional\Adapter;

use Doctrine\ORM\Id\AssignedGenerator;
use Doctrine\ORM\Mapping\ClassMetadata;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Sulu\Bundle\MediaBundle\Entity\CollectionType;
use Sulu\Bundle\MediaBundle\Entity\MediaType;
use Sulu\Bundle\MediaBundle\Media\Storage\StorageInterface;
use Sulu\Bundle\SyliusConsumerBundle\Adapter\ImageMediaAdapter;
use Sulu\Bundle\SyliusConsumerBundle\Payload\ImagePayload;
use Sulu\Bundle\SyliusConsumerBundle\Repository\ImageMediaBridgeRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Service\SyliusImageDownloaderInterface;
use Sulu\Bundle\SyliusConsumerBundle\Tests\Functional\Mocks\Storage;
use Sulu\Bundle\SyliusConsumerBundle\Tests\Functional\Mocks\SyliusImageDownloader;
use Sulu\Bundle\SyliusConsumerBundle\Tests\MockSyliusData;
use Sulu\Bundle\TestBundle\Testing\KernelTestCase;
use Sulu\Bundle\TestBundle\Testing\PurgeDatabaseTrait;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageMediaAdapterTest extends KernelTestCase
{
    use ProphecyTrait;
    use PurgeDatabaseTrait;

    /**
     * @var ObjectProphecy|SyliusImageDownloaderInterface
     */
    private $syliusImageDownloaderMock;

    /**
     * @var ObjectProphecy|StorageInterface
     */
    private $storageMock;

    protected function setUp(): void
    {
        parent::setUp();

        self::purgeDatabase();

        /** @var SyliusImageDownloader $syliusImageDownloader */
        $syliusImageDownloader = static::getContainer()->get(SyliusImageDownloaderInterface::class);
        $this->syliusImageDownloaderMock = $this->prophesize(SyliusImageDownloaderInterface::class);
        $syliusImageDownloader->setMock($this->syliusImageDownloaderMock->reveal());

        /** @var Storage $storage */
        $storage = static::getContainer()->get('sulu_media.storage');
        $this->storageMock = $this->prophesize(StorageInterface::class);
        $storage->setMock($this->storageMock->reveal());
    }

    public function testSynchronize(): void
    {
        $imageMediaType = (new MediaType())->setName('image');
        $this->setId($imageMediaType, 2);
        $systemCollectionType = (new CollectionType())->setName('System Collections')->setKey('collection.system');
        $this->setId($systemCollectionType, 2);
        self::getEntityManager()->persist($imageMediaType);
        self::getEntityManager()->persist($systemCollectionType);
        self::getEntityManager()->flush();

        $adapter = self::getContainer()->get(ImageMediaAdapter::class);

        $payload = MockSyliusData::PRODUCT['images'][0];
        $imagePayload = new ImagePayload($payload['id'], 'en', $payload);

        /** @var UploadedFile|ObjectProphecy $uploadedFile */
        $uploadedFile = $this->prophesize(UploadedFile::class)->willBeConstructedWith(
            [
                __DIR__ . \DIRECTORY_SEPARATOR . '..' . \DIRECTORY_SEPARATOR . 'resources' . \DIRECTORY_SEPARATOR . 'test.txt',
                1,
                null,
                null,
                1,
                true,
            ]
        );
        $uploadedFile->getClientOriginalName()->willReturn('File 123.jpg');
        $uploadedFile->getPathname()->willReturn('');
        $uploadedFile->getSize()->willReturn('123');
        $uploadedFile->getMimeType()->willReturn('img');
        $uploadedFile->getFilename()->willReturn('File 123.jpg');

        $this->storageMock->save('', 'File 123.jpg', [])->willReturn([]);

        $this->syliusImageDownloaderMock->downloadImage(Argument::any())->willReturn($uploadedFile->reveal());

        $adapter->synchronize($imagePayload);

        /** @var ImageMediaBridgeRepositoryInterface $imageBridgeRepository */
        $imageBridgeRepository = self::getContainer()->get('sulu.repository.image_media_bridge');
        $imageBridge = $imageBridgeRepository->findById(1);

        self::assertNotNull($imageBridge);
        self::assertNotNull($imageBridge->getMedia());
    }

    /**
     * @param int|string $id
     */
    private function setId(object $object, $id): void
    {
        $metadata = self::getEntityManager()->getClassMetaData(\get_class($object));
        $metadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);
        $metadata->setIdGenerator(new AssignedGenerator());

        $reflection = new \ReflectionClass($object);
        $property = $reflection->getProperty('id');
        $property->setAccessible(true);
        $property->setValue($object, $id);
    }
}
