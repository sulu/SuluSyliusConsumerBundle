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

namespace Sulu\Bundle\SyliusConsumerBundle\Message;

/**
 * @internal
 */
class SynchronizeProductVariantMessage
{
    /**
     * @var string
     */
    private $productCode;

    /**
     * @var string
     */
    private $code;

    /**
     * @var mixed[]
     */
    private $payload;

    public function __construct(string $productCode, string $code, array $payload)
    {
        $this->productCode = $productCode;
        $this->code = $code;
        $this->payload = $payload;
    }

    public function getProductCode(): string
    {
        return $this->productCode;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getPayload(): array
    {
        return $this->payload;
    }
}
