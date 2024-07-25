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

namespace Sulu\Bundle\SyliusConsumerBundle\Tests\Unit\Entity;

use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Sulu\Bundle\MediaBundle\Entity\MediaInterface;
use Sulu\Bundle\SyliusConsumerBundle\Entity\ImageMediaBridge;

class ImageMediaBridgeTest extends TestCase
{
    use ProphecyTrait;

    public function testGetId(): void
    {
        $media = $this->prophesize(MediaInterface::class);
        $entity = new ImageMediaBridge(42, $media->reveal());

        $this->assertEquals(42, $entity->getImageId());
    }

    public function testGetMedia(): void
    {
        $media = $this->prophesize(MediaInterface::class);
        $entity = new ImageMediaBridge(42, $media->reveal());

        $this->assertEquals($media->reveal(), $entity->getMedia());
    }
}
