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

namespace Sulu\Bundle\SyliusConsumerBundle\Security;

use Sulu\Bundle\SyliusConsumerBundle\Model\Customer\Customer;
use Symfony\Component\Security\Core\User\UserInterface;

interface SyliusUserInterface extends UserInterface
{
    public function getCustomer(): Customer;

    public function getId(): int;
}
