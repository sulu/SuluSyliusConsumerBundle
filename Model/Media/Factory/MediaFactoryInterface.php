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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Media\Factory;

use Sulu\Bundle\MediaBundle\Entity\MediaInterface;
use Symfony\Component\HttpFoundation\File\File as SymfonyFile;

interface MediaFactoryInterface
{
    public function create(
        SymfonyFile $uploadedFile,
        ?string $filename,
        string $collectionKey,
        array $titles
    ): MediaInterface;

    public function update(
        MediaInterface $media,
        SymfonyFile $uploadedFile,
        ?string $filename,
        array $titles
    ): MediaInterface;

    public function updateTitles(MediaInterface $media, array $titles): void;
}
