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

namespace Sulu\Bundle\SyliusConsumerBundle\Entity;

use Sulu\Bundle\CategoryBundle\Entity\CategoryInterface;

class TaxonCategoryBridge implements TaxonCategoryBridgeInterface
{
    /**
     * @var int
     */
    private $taxonId;

    /**
     * @var CategoryInterface
     */
    private $category;

    public function __construct(int $taxonId, CategoryInterface $category)
    {
        $this->taxonId = $taxonId;
        $this->category = $category;
    }

    public function getTaxonId(): int
    {
        return $this->taxonId;
    }

    public function getCategory(): CategoryInterface
    {
        return $this->category;
    }
}
