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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Product\Query;

class FindDraftProductQuery
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $locale;

    public function __construct(string $id, string $locale)
    {
        $this->id = $id;
        $this->locale = $locale;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }
}
