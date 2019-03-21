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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Address\Query;

use Sulu\Bundle\SyliusConsumerBundle\Model\Address\AddressInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\MissingResultException;

class FindAddressQuery
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var AddressInterface|null
     */
    private $address;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getAddress(): AddressInterface
    {
        if (!$this->address) {
            throw new MissingResultException(__METHOD__);
        }

        return $this->address;
    }

    public function setAddress(AddressInterface $address): self
    {
        $this->address = $address;

        return $this;
    }
}
