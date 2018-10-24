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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Media;

use Doctrine\ORM\EntityManagerInterface;
use Sulu\Bundle\MediaBundle\Entity\Collection;
use Sulu\Bundle\MediaBundle\Entity\File;
use Sulu\Bundle\MediaBundle\Entity\FileVersion;
use Sulu\Bundle\MediaBundle\Entity\FileVersionMeta;
use Sulu\Bundle\MediaBundle\Entity\MediaInterface;
use Sulu\Bundle\MediaBundle\Entity\MediaRepository;
use Sulu\Bundle\MediaBundle\Entity\MediaType;
use Sulu\Bundle\MediaBundle\Media\Storage\StorageInterface;
use Sulu\Bundle\MediaBundle\Media\TypeManager\TypeManager;
use Sulu\Component\Media\SystemCollections\SystemCollectionManagerInterface;
use Symfony\Component\HttpFoundation\File\File as SymfonyFile;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class MediaFactory
{
    /**
     * @var StorageInterface
     */
    private $mediaStorage;

    /**
     * @var MediaRepository
     */
    private $mediaRepository;

    /**
     * @var TypeManager
     */
    private $mediaTypeManager;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var SystemCollectionManagerInterface
     */
    private $systemCollectionManager;

    public function __construct(
        StorageInterface $mediaStorage,
        MediaRepository $mediaRepository,
        TypeManager $mediaTypeManager,
        EntityManagerInterface $entityManager,
        SystemCollectionManagerInterface $systemCollectionManager
    ) {
        $this->mediaStorage = $mediaStorage;
        $this->mediaRepository = $mediaRepository;
        $this->mediaTypeManager = $mediaTypeManager;
        $this->entityManager = $entityManager;
        $this->systemCollectionManager = $systemCollectionManager;
    }

    public function create(
        SymfonyFile $uploadedFile,
        string $collectionKey,
        string $title,
        string $locale
    ): MediaInterface {
        /** @var Collection $collection */
        $collection = $this->entityManager->getReference(
            Collection::class,
            $collectionId = $this->systemCollectionManager->getSystemCollection($collectionKey)
        );
        /** @var MediaType $mediaType */
        $mediaType = $this->entityManager->getReference(
            MediaType::class, $this->mediaTypeManager->getMediaType($this->getMimeType($uploadedFile))
        );
        /** @var MediaInterface $media */
        $media = $this->mediaRepository->createNew();
        $file = new File();
        $file->setVersion(0);
        $file->setMedia($media);
        $media->addFile($file);
        $media->setType($mediaType);
        $media->setCollection($collection);

        $this->update($media, $uploadedFile, $title, $locale);

        $this->entityManager->persist($file);
        $this->entityManager->persist($media);

        return $media;
    }

    public function update(
        MediaInterface $media,
        SymfonyFile $uploadedFile,
        string $title,
        string $locale
    ): MediaInterface {
        $fileName = $uploadedFile->getFilename();

        if ($uploadedFile instanceof UploadedFile) {
            $fileName = $uploadedFile->getClientOriginalName();
        }

        $storageOptions = $this->mediaStorage->save($uploadedFile->getPathname(), $fileName, 1);

        $file = $media->getFiles()[0];
        $file->setVersion($file->getVersion() + 1);

        $fileVersion = new FileVersion();
        $fileVersion->setVersion($file->getVersion());
        $fileVersion->setSize($uploadedFile->getSize());
        $fileVersion->setName($fileName);
        $fileVersion->setStorageOptions($storageOptions);
        $fileVersion->setMimeType($this->getMimeType($uploadedFile));
        $fileVersion->setFile($file);
        $file->addFileVersion($fileVersion);
        $fileVersionMeta = new FileVersionMeta();
        $fileVersionMeta->setTitle($title);
        $fileVersionMeta->setDescription('');
        $fileVersionMeta->setLocale($locale);
        $fileVersionMeta->setFileVersion($fileVersion);
        $fileVersion->addMeta($fileVersionMeta);
        $fileVersion->setDefaultMeta($fileVersionMeta);

        $this->entityManager->persist($fileVersionMeta);
        $this->entityManager->persist($fileVersion);

        return $media;
    }

    private function getMimeType(SymfonyFile $file): string
    {
        return $file->getMimeType() ?: '';
    }
}
