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

class User
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var null|string
     */
    private $username;

    /**
     * @var array
     */
    private $roles;

    /**
     * @var bool
     */
    private $enabled;

    /**
     * @var null|string
     */
    private $token;

    public function __construct(int $id, ?string $username, array $roles, bool $enabled, ?string $token)
    {
        $this->id = $id;
        $this->username = $username;
        $this->roles = $roles;
        $this->enabled = $enabled;
        $this->token = $token;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }
}
