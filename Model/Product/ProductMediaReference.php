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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Product;

use Sulu\Bundle\MediaBundle\Entity\MediaInterface;

class ProductMediaReference
{
    /**
     * @var MediaInterface
     */
    private $media;

    /**
     * @var string
     */
    private $type;

    /**
     * @var int
     */
    private $sorting;

    /**
     * @var int
     */
    private $syliusId;

    /**
     * @var string
     */
    private $syliusPath;

    /**
     * @var bool
     */
    private $active = true;

    /**
     * @var ProductInterface
     */
    private $product;

    public function __construct(ProductInterface $product, MediaInterface $media, string $type, ?int $syliusId)
    {
        $this->product = $product;
        $this->media = $media;
        $this->type = $type;
        $this->syliusId = $syliusId;
    }

    public function getProduct(): ProductInterface
    {
        return $this->product;
    }

    public function getMedia(): MediaInterface
    {
        return $this->media;
    }

    public function getMediaId(): int
    {
        return $this->media->getId();
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        if ($this->syliusId) {
            throw new \RuntimeException('Sylius MediaReferences "type" is not changeable');
        }

        $this->type = $type;

        return $this;
    }

    public function getSyliusId(): ?int
    {
        return $this->syliusId;
    }

    public function getSorting(): int
    {
        return $this->sorting;
    }

    public function setSorting(int $sorting): self
    {
        $this->sorting = $sorting;

        return $this;
    }

    public function getSyliusPath(): ?string
    {
        return $this->syliusPath;
    }

    public function setSyliusPath(string $syliusPath): self
    {
        $this->syliusPath = $syliusPath;

        return $this;
    }

    public function getActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        if (!$this->syliusId) {
            throw new \RuntimeException('Sulu MediaReferences "active" property is not changeable');
        }

        $this->active = $active;

        return $this;
    }
}
