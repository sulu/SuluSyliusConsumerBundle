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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Product\Query;

class LoadProductVariantStockQuery
{
    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $variantCode;

    /**
     * @var int
     */
    private $onHold;

    /**
     * @var int
     */
    private $onHand;

    public function __construct(string $code, string $variantCode)
    {
        $this->code = $code;
        $this->variantCode = $variantCode;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getVariantCode(): string
    {
        return $this->variantCode;
    }

    public function getChannel(): string
    {
        return $this->channel;
    }

    public function getOnHold(): int
    {
        return $this->onHold;
    }

    public function setOnHold(int $onHold): self
    {
        $this->onHold = $onHold;

        return $this;
    }

    public function getOnHand(): int
    {
        return $this->onHand;
    }

    public function setOnHand(int $onHand): self
    {
        $this->onHand = $onHand;

        return $this;
    }
}
