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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Customer\Message;

use Sulu\Bundle\SyliusConsumerBundle\Model\Customer\CustomerInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\MissingResultException;

class CreateCustomerMessage
{
    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $plainPassword;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @var string
     */
    private $gender;

    /**
     * @var bool
     */
    private $enabled;

    /**
     * @var CustomerInterface|null
     */
    private $customer;

    public function __construct(
        string $email,
        string $plainPassword,
        string $firstName,
        string $lastName,
        string $gender,
        bool $enabled = false
    ) {
        $this->email = $email;
        $this->plainPassword = $plainPassword;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->gender = $gender;
        $this->enabled = $enabled;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPlainPassword(): string
    {
        return $this->plainPassword;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function getCustomer(): CustomerInterface
    {
        if (!$this->customer) {
            throw new MissingResultException(__METHOD__);
        }

        return $this->customer;
    }

    public function setCustomer(CustomerInterface $customer): self
    {
        $this->customer = $customer;

        return $this;
    }
}
