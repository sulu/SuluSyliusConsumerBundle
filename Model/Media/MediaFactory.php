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
        array $titles
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

        $this->update($media, $uploadedFile, $titles);

        $this->entityManager->persist($file);
        $this->entityManager->persist($media);

        return $media;
    }

    public function update(
        MediaInterface $media,
        SymfonyFile $uploadedFile,
        array $titles
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

        foreach ($titles as $locale => $title) {
            $this->createFileVersionMeta($fileVersion, $title, $locale);
        }

        $this->entityManager->persist($fileVersion);

        return $media;
    }

    public function updateTitles(MediaInterface $media, array $titles): void
    {
        $processedLocales = [];
        $latestFileVersion = $media->getFiles()[0]->getLatestFileVersion();
        foreach ($media->getFiles()[0]->getLatestFileVersion()->getMeta() as $meta) {
            if (array_key_exists($meta->getLocale(), $titles)) {
                $meta->setTitle($titles[$meta->getLocale()]);
            } else {
                $this->entityManager->remove($latestFileVersion);
            }
            $processedLocales[] = $meta->getLocale();
        }

        foreach ($titles as $locale => $title) {
            if (!in_array($locale, $processedLocales)) {
                $this->createFileVersionMeta($latestFileVersion, $title, $locale);
            }
        }
    }

    protected function createFileVersionMeta(
        FileVersion $fileVersion,
        string $title,
        string $locale
    ): void {
        $fileVersionMeta = new FileVersionMeta();
        $fileVersionMeta->setTitle($title);
        $fileVersionMeta->setDescription('');
        $fileVersionMeta->setLocale($locale);
        $fileVersionMeta->setFileVersion($fileVersion);

        $fileVersion->addMeta($fileVersionMeta);

        if (count($fileVersion->getMeta()) === 1) {
            $fileVersion->setDefaultMeta($fileVersionMeta);
        }

        $this->entityManager->persist($fileVersionMeta);
    }

    private function getMimeType(SymfonyFile $file): string
    {
        return $file->getMimeType() ?: '';
    }
}
