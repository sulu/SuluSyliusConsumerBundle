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

use Doctrine\ORM\EntityManagerInterface;
use Sulu\Bundle\CategoryBundle\Entity\CategoryTranslationInterface;
use Sulu\Bundle\CategoryBundle\Entity\CategoryTranslationRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Category\CategoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Category\CategoryRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\SynchronizeTaxonMessage;

class SynchronizeTaxonMessageHandler
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepository;

    /**
     * @var CategoryTranslationRepositoryInterface
     */
    private $categoryTranslationRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        CategoryRepositoryInterface $categoryRepository,
        CategoryTranslationRepositoryInterface $categoryTranslationRepository
    ) {
        $this->entityManager = $entityManager;
        $this->categoryRepository = $categoryRepository;
        $this->categoryTranslationRepository = $categoryTranslationRepository;
    }

    public function __invoke(SynchronizeTaxonMessage $message): void
    {
        $parent = null;
        if ($message->getLevel() !== 0) {
            $parentValueObject = $message->getParent();

            if (!$parentValueObject) {
                throw new \RuntimeException('Required "parent" not provided');
            }

            $parent = $this->categoryRepository->findBySyliusId($parentValueObject->getId());

            if (!$parent) {
                throw new \RuntimeException('Category with "syliusId" "' . $parentValueObject->getId() . '" not found.');
            }
        }

        $this->synchronizeCategory($message, $parent);
    }

    protected function synchronizeCategory(SynchronizeTaxonMessage $message, CategoryInterface $parent = null): void
    {
        $category = $this->categoryRepository->findBySyliusId($message->getId());
        if (!$category) {
            /** @var CategoryInterface $category */
            $category = $this->categoryRepository->createNew();
            $this->entityManager->persist($category);

            $category->setSyliusId($message->getId());
        }

        if ($parent) {
            $category->setParent($parent);
        }

        $category->setKey($message->getCode());
        $category->setDefaultLocale('de');

        foreach ($message->getTranslations() as $translationValueObject) {
            /** @var CategoryTranslationInterface $categoryTranslation */
            $categoryTranslation = $category->findTranslationByLocale($translationValueObject->getLocale());
            if (!$categoryTranslation) {
                $categoryTranslation = $this->categoryTranslationRepository->createNew();
                $this->entityManager->persist($categoryTranslation);
                $category->addTranslation($categoryTranslation);
            }

            $categoryTranslation->setCategory($category);
            $categoryTranslation->setLocale($translationValueObject->getLocale());
            $categoryTranslation->setTranslation($translationValueObject->getName());
            $categoryTranslation->setDescription($translationValueObject->getDescription());
        }

        // TODO: Sync also images

        /** @var SynchronizeTaxonMessage $child */
        foreach ($message->getChildren() as $child) {
            $this->synchronizeCategory($child, $category);
        }
    }
}
