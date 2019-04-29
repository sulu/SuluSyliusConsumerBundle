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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Customer;

use Sulu\Bundle\SyliusConsumerBundle\Model\User\User;

class Customer implements CustomerInterface
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $emailCanonical;

    /**
     * @var string
     */
    private $gender;

    /**
     * @var string|null
     */
    private $firstName;

    /**
     * @var string|null
     */
    private $lastName;

    /**
     * @var User
     */
    private $user;

    /**
     * @var array
     */
    private $customData;

    public function __construct(
        User $user,
        int $id,
        string $email,
        string $emailCanonical,
        string $gender,
        ?string $firstName = null,
        ?string $lastName = null,
        array $customData = []
    ) {
        $this->user = $user;
        $this->id = $id;
        $this->email = $email;
        $this->emailCanonical = $emailCanonical;
        $this->gender = $gender;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->customData = $customData;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getEmailCanonical(): string
    {
        return $this->emailCanonical;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function getFullName()
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getCustomData(): array
    {
        return $this->customData;
    }
}
