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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Address;

interface AddressInterface
{
    public function getFirstName(): string;

    public function getLastName(): string;

    public function getCity(): string;

    public function getPostcode(): string;

    public function getStreet(): string;

    public function getCountryCode(): string;

    public function getProvinceCode(): ?string;

    public function toArray(): array;
}
