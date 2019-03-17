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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message;

use Sulu\Bundle\SyliusConsumerBundle\Model\MissingResultException;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductVariantInterface;

class PublishProductVariantMessage
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $locale;

    /**
     * @var bool
     */
    private $mandatory;

    /**
     * @var ProductVariantInterface|null
     */
    private $productVariant;

    public function __construct(string $id, string $locale, bool $mandatory = true)
    {
        $this->id = $id;
        $this->locale = $locale;
        $this->mandatory = $mandatory;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function getMandatory(): bool
    {
        return $this->mandatory;
    }

    public function getProductVariant(): ProductVariantInterface
    {
        if (!$this->productVariant) {
            throw new MissingResultException(__METHOD__);
        }

        return $this->productVariant;
    }

    public function setProductVariant(ProductVariantInterface $productVariant): self
    {
        $this->productVariant = $productVariant;

        return $this;
    }
}
