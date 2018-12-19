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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\User;

use Symfony\Component\Security\Core\User\UserInterface as SymfonyUserInterface;

interface UserInterface extends SymfonyUserInterface
{
    public function getId(): int;

    public function getUsername(): ?string;

    public function getRoles(): array;

    public function getEmail(): string;

    public function eraseCredentials(): void;

    public function getPassword(): ?string;

    public function getSalt(): ?string;

    public function getFirstName(): ?string;

    public function getLastName(): ?string;
}
