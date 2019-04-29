<?php

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Customer;

use Sulu\Bundle\SyliusConsumerBundle\Model\User\User;

interface CustomerInterface
{
    public function getId(): int;

    public function getEmail(): string;

    public function getEmailCanonical(): string;

    public function getGender(): string;

    public function getFirstName(): ?string;

    public function getLastName(): ?string;

    public function getFullName();

    public function getUser(): User;

    public function getCustomData(): array;
}
