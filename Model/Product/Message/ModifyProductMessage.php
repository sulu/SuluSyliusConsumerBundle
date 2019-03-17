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
use Sulu\Bundle\SyliusConsumerBundle\Model\PayloadTrait;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\ValueObject\MediaReferenceValueObject;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;

class ModifyProductMessage
{
    use PayloadTrait;

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $locale;

    /**
     * @var ProductInterface|null
     */
    private $product;

    public function __construct(string $id, string $locale, array $payload)
    {
        $this->id = $id;
        $this->locale = $locale;
        $this->initializePayload($payload);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    /**
     * @return MediaReferenceValueObject[]
     */
    public function getMediaReferences(): array
    {
        $mediaReferences = [];
        foreach ($this->getArrayValue('mediaReferences') as $mediaReferencePayload) {
            $mediaReferences[] = new MediaReferenceValueObject($mediaReferencePayload);
        }

        return $mediaReferences;
    }

    public function getProduct(): ProductInterface
    {
        if (!$this->product) {
            throw new MissingResultException(__METHOD__);
        }

        return $this->product;
    }

    public function setProduct(ProductInterface $product): self
    {
        $this->product = $product;

        return $this;
    }
}
