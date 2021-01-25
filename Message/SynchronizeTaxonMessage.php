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

namespace Sulu\Bundle\SyliusConsumerBundle\Message;

/**
 * @internal
 */
class SynchronizeTaxonMessage
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var mixed[]
     */
    private $payload;

    public function __construct(int $id, array $payload)
    {
        $this->id = $id;
        $this->payload = $payload;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getPayload()
    {
        return $this->payload;
    }
}
