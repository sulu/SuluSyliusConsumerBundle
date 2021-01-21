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

namespace Sulu\Bundle\SyliusConsumerBundle\Handler;

use Sulu\Bundle\SyliusConsumerBundle\Message\RemoveTaxonMessage;

class RemoveTaxonMessageHandler
{
    public function __invoke(RemoveTaxonMessage $message): void
    {
    }
}
