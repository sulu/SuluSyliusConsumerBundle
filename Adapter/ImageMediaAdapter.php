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

namespace Sulu\Bundle\SyliusConsumerBundle\Adapter;

use Doctrine\ORM\EntityManagerInterface;
use Sulu\Bundle\MediaBundle\Entity\Collection;
use Sulu\Bundle\MediaBundle\Entity\File;
use Sulu\Bundle\MediaBundle\Entity\FileVersion;
use Sulu\Bundle\MediaBundle\Entity\FileVersionMeta;
use Sulu\Bundle\MediaBundle\Entity\Media;
use Sulu\Bundle\MediaBundle\Entity\MediaInterface;
use Sulu\Bundle\MediaBundle\Entity\MediaRepositoryInterface;
use Sulu\Bundle\MediaBundle\Media\Storage\StorageInterface;
use Sulu\Bundle\SyliusConsumerBundle\Payload\ImagePayload;
use Sulu\Bundle\SyliusConsumerBundle\Repository\ImageMediaBridgeRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Service\SyliusImageDownloaderInterface;
use Sulu\Component\Media\SystemCollections\SystemCollectionManagerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageMediaAdapter implements ImageAdapterInterface
{
    private const IMAGE_MEDIA_TYPE = 'image';

    /**
     * @var ImageMediaBridgeRepositoryInterface
     */
    private $mediaBridgeRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var StorageInterface
     */
    private $storage;

    /**
     * @var SystemCollectionManagerInterface
     */
    private $systemCollectionManager;

    /**
     * @var string
     */
    private $collectionKey;

    /**
     * @var SyliusImageDownloaderInterface
     */
    private $syliusImageDownloader;

    /**
     * @var MediaRepositoryInterface|null
     */
    private $mediaRepository;

    public function __construct(
        ImageMediaBridgeRepositoryInterface $mediaBridgeRepository,
        EntityManagerInterface $entityManager,
        StorageInterface $storage,
        SystemCollectionManagerInterface $systemCollectionManager,
        SyliusImageDownloaderInterface $syliusImageDownloader,
        string $collectionKey,
        ?MediaRepositoryInterface $mediaRepository = null
    ) {
        $this->mediaBridgeRepository = $mediaBridgeRepository;
        $this->entityManager = $entityManager;
        $this->storage = $storage;
        $this->systemCollectionManager = $systemCollectionManager;
        $this->collectionKey = $collectionKey;
        $this->syliusImageDownloader = $syliusImageDownloader;
        $this->mediaRepository = $mediaRepository;

        if (null === $mediaRepository) {
            @trigger_deprecation(
                'sulu/sylius-consumer-bundle',
                '0.5',
                'Omitting the "mediaRepository" argument is deprecated and will not longer work in SuluSyliusConsumerBundle 1.0.'
            );
        }
    }

    public function synchronize(ImagePayload $payload): void
    {
        $this->handlePayload($payload);

        // Needed to use medias in other adapters
        $this->entityManager->flush();
    }

    public function remove(int $id): void
    {
        $bridge = $this->mediaBridgeRepository->findById($id);
        if ($bridge) {
            $this->entityManager->remove($bridge->getMedia());

            return;
        }

        $this->mediaBridgeRepository->removeById($id);
    }

    private function handlePayload(ImagePayload $payload): void
    {
        $bridge = $this->mediaBridgeRepository->findById($payload->getId());
        if (!$bridge) {
            $media = $this->mediaRepository ? $this->mediaRepository->createNew() : new Media();
            $bridge = $this->mediaBridgeRepository->create($payload->getId(), $media);
        }

        $media = $bridge->getMedia();
        $uploadedFile = $this->syliusImageDownloader->downloadImage($payload);
        $this->updateMedia($media, $uploadedFile, $payload->getLocale());
        $this->removeTemporaryMediaFile($uploadedFile);
        $this->entityManager->persist($bridge);
    }

    private function removeTemporaryMediaFile(UploadedFile $uploadedFile): void
    {
        $filesystem = new Filesystem();
        $filePath = $uploadedFile->getPathname();
        if ($filesystem->exists($filePath) && $uploadedFile->isFile()) {
            $filesystem->remove($filePath);
        }
    }

    private function updateMedia(MediaInterface $media, UploadedFile $uploadedFile, string $locale): MediaInterface
    {
        $latestFileVersion = null;
        $existingFile = null;
        if ($media->getFiles()->count() > 0) {
            $existingFile = $media->getFiles()->first();
            $latestFileVersion = $existingFile->getLatestFileVersion();

            if ($latestFileVersion && $latestFileVersion->getSize() === $uploadedFile->getSize()) {
                try {
                    $this->storage->load($latestFileVersion->getStorageOptions());

                    // same image, not necessary to update anything
                    return $media;
                } catch (\Exception $e) {
                    // file not found, continue
                }
            }
        }

        $storageOptions = $this->storage->save(
            $uploadedFile->getPathname(),
            $uploadedFile->getFilename()
        );

        $file = $existingFile ?? new File();
        $file->setVersion($latestFileVersion ? $latestFileVersion->getVersion() + 1 : 1)
            ->setMedia($media);

        if (!$existingFile) {
            $media->addFile($file)
                ->setType(self::IMAGE_MEDIA_TYPE)
                ->setCollection($this->getCollection());
        }

        $fileVersion = new FileVersion();
        $fileVersion->setVersion($file->getVersion())
            ->setSize($uploadedFile->getSize())
            ->setName($uploadedFile->getFilename())
            ->setStorageOptions($storageOptions)
            ->setMimeType($uploadedFile->getMimeType() ?: 'image/jpeg')
            ->setFile($file);

        $file->addFileVersion($fileVersion);

        $fileVersionMeta = new FileVersionMeta();
        $fileVersionMeta->setTitle($uploadedFile->getFilename())
            ->setLocale($locale)
            ->setFileVersion($fileVersion);

        $fileVersion->addMeta($fileVersionMeta)
            ->setDefaultMeta($fileVersionMeta);

        $this->entityManager->persist($fileVersionMeta);
        $this->entityManager->persist($fileVersion);
        $this->entityManager->persist($media);

        return $media;
    }


    private function getCollection(): Collection
    {
        $collectionId = $this->systemCollectionManager->getSystemCollection($this->collectionKey);

        return $this->entityManager->find(Collection::class, $collectionId);
    }
}
