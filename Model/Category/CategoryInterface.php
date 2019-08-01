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

use Sulu\Bundle\CategoryBundle\Entity\CategoryInterface as BaseCategoryInterface;

interface CategoryInterface extends BaseCategoryInterface
{
    public function getSyliusId(): ?int;

    public function setSyliusId(?int $syliusId): self;

    public function getSyliusCode(): ?string;

    public function setSyliusCode(?string $syliusCode): self;
}
