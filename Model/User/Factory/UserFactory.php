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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\User\Factory;

use Sulu\Bundle\SyliusConsumerBundle\Model\PayloadTrait;
use Sulu\Bundle\SyliusConsumerBundle\Model\User\User;

class UserFactory implements UserFactoryInterface
{
    use PayloadTrait;

    public function createFromArray(array $data): User
    {
        $this->initializePayload($data);

        $customer = new User(
            $this->getIntValue('id'),
            $this->keyExists('username') ? $this->getNullableStringValue('username') : null,
            $this->getArrayValueWithDefault('roles'),
            $this->getBoolValue('enabled'),
            $this->getStringValue('hash'),
            $this->keyExists('token') ? $this->getNullableStringValue('token') : null
        );

        return $customer;
    }
}
