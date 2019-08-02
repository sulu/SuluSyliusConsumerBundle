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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Product\Handler\Message;

use Sulu\Bundle\CategoryBundle\Category\CategoryManagerInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Category\CategoryRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\RemoveTaxonMessage;

class RemoveTaxonMessageHandler
{
    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepository;

    /**
     * @var CategoryManagerInterface
     */
    private $categoryManager;

    public function __construct(
        CategoryRepositoryInterface $categoryRepository,
        CategoryManagerInterface $categoryManager
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->categoryManager = $categoryManager;
    }

    public function __invoke(RemoveTaxonMessage $message): void
    {
        $id = $this->categoryRepository->findIdBySyliusId($message->getId());
        if (!$id) {
            return;
        }

        $this->categoryManager->delete($id);
    }
}
