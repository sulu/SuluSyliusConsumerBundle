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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Content\View;

use Sulu\Bundle\SyliusConsumerBundle\Model\Content\ContentInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\ContentViewInterface;

interface ContentViewFactoryInterface
{
    /**
     * @param ContentInterface[] $dimensions
     */
    public function create(array $dimensions): ?ContentViewInterface;

    /**
     * @param ContentInterface[] $dimensions
     */
    public function loadAndCreate(string $resourceKey, string $resourceId, array $dimensions): ?ContentViewInterface;
}
