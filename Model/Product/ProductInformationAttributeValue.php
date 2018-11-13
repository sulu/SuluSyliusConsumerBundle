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

class ProductInformationAttributeValue implements ProductInformationAttributeValueInterface
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $type;

    /**
     * @var null|string
     */
    private $textValue;

    /**
     * @var null|string
     */
    private $textAreaValue;

    /**
     * @var null|bool
     */
    private $booleanValue;

    /**
     * @var null|int
     */
    private $integerValue;

    /**
     * @var null|float
     */
    private $floatValue;

    /**
     * @var null|\DateTimeInterface
     */
    private $dateTimeValue;

    /**
     * @var null|\DateTimeInterface
     */
    private $dateValue;

    /**
     * @var null|array
     */
    private $selectValue;

    /**
     * @var ProductInformationInterface
     */
    private $productInformation;

    public function __construct(ProductInformationInterface $productInformation, string $code, string $type)
    {
        $this->productInformation = $productInformation;
        $this->code = $code;
        $this->type = $type;
    }

    public static function getGetterByType(string $type): string
    {
        return $type . 'Value';
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setValue($value): ProductInformationAttributeValueInterface
    {
        $this->{$this->type . 'Value'} = $value;

        return $this;
    }

    public function getValue()
    {
        return $this->{$this->getGetterByType($this->type)};
    }
}
