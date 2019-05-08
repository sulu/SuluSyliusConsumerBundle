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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Address\Factory;

use Sulu\Bundle\SyliusConsumerBundle\Model\Address\Address;
use Sulu\Bundle\SyliusConsumerBundle\Model\Address\AddressInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\PayloadTrait;

class AddressFactory implements AddressFactoryInterface
{
    use PayloadTrait;

    public function createFromArray(array $data): AddressInterface
    {
        $this->initializePayload($data);

        $address = new Address(
            $this->keyExists('id') ? $this->getIntValue('id') : null,
            $this->getStringValue('firstName'),
            $this->getStringValue('lastName'),
            $this->getStringValue('street'),
            $this->getStringValue('postcode'),
            $this->getStringValue('city'),
            $this->getStringValue('countryCode'),
            $this->keyExists('provinceCode') ? $this->getStringValue('provinceCode') : null,
            $this->keyExists('phoneNumber') ? $this->getStringValue('phoneNumber') : null,
            $this->keyExists('company') ? $this->getStringValue('company') : null
        );

        return $address;
    }
}
