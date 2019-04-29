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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Customer\Factory;

use Sulu\Bundle\SyliusConsumerBundle\Model\Customer\Customer;
use Sulu\Bundle\SyliusConsumerBundle\Model\Customer\CustomerInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\PayloadTrait;
use Sulu\Bundle\SyliusConsumerBundle\Model\User\Factory\UserFactoryInterface;

class CustomerFactory implements CustomerFactoryInterface
{
    use PayloadTrait;

    /**
     * @var UserFactoryInterface
     */
    private $userFactory;

    public function __construct(UserFactoryInterface $userFactory)
    {
        $this->userFactory = $userFactory;
    }

    public function createFromArray(array $data): CustomerInterface
    {
        $this->initializePayload($data);

        $customer = new Customer(
            $this->userFactory->createFromArray($data['user']),
            $this->getIntValue('id'),
            $this->getStringValue('email'),
            $this->getStringValue('emailCanonical'),
            $this->getStringValue('gender'),
            $this->keyExists('firstName') ? $this->getStringValue('firstName') : null,
            $this->keyExists('lastName') ? $this->getStringValue('lastName') : null,
            $this->getArrayValueWithDefault('customData')
        );

        return $customer;
    }
}
