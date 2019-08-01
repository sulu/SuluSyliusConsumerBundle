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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Category;

use Sulu\Bundle\CategoryBundle\Entity\Category as BaseCategory;

class Category extends BaseCategory implements CategoryInterface
{
    /**
     * @var int|null
     */
    private $syliusId;

    /**
     * @var string|null
     */
    private $syliusCode;

    public function getSyliusId(): ?int
    {
        return $this->syliusId;
    }

    public function setSyliusId(?int $syliusId): CategoryInterface
    {
        $this->syliusId = $syliusId;

        return $this;
    }

    public function getSyliusCode(): ?string
    {
        return $this->syliusCode;
    }

    public function setSyliusCode(?string $syliusCode): CategoryInterface
    {
        $this->syliusCode = $syliusCode;

        return $this;
    }
}
