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
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionInterface;

interface ContentViewFactoryInterface
{
    /**
     * @param ContentInterface[] $contentDimensions
     */
    public function create(array $contentDimensions): ?ContentViewInterface;

    /**
     * @param DimensionInterface[] $dimensions
     */
    public function loadAndCreate(string $resourceKey, string $resourceId, array $dimensions): ?ContentViewInterface;
}
