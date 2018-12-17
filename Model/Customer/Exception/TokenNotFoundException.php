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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Customer\Exception;

use Sulu\Bundle\SyliusConsumerBundle\Model\ModelNotFoundException;

class TokenNotFoundException extends ModelNotFoundException
{
    public function __construct(string $token, $code = 0, \Throwable $previous = null)
    {
        parent::__construct('Token', $token, $code, $previous);
    }
}
