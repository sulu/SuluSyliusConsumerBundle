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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\Exception;

use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionAttribute;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\ModelNotFoundException;

class DimensionAttributeNotFoundException extends ModelNotFoundException
{
    public function __construct(DimensionInterface $dimension, string $key, $code = 0, \Throwable $previous = null)
    {
        parent::__construct(DimensionAttribute::class, sprintf('%s#%s', $dimension->getId(), $key), $code, $previous);
    }
}
