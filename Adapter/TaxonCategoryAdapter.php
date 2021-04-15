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

namespace Sulu\Bundle\SyliusConsumerBundle\Adapter;

use Doctrine\ORM\EntityManagerInterface;
use Sulu\Bundle\CategoryBundle\Entity\CategoryInterface;
use Sulu\Bundle\CategoryBundle\Entity\CategoryRepositoryInterface;
use Sulu\Bundle\CategoryBundle\Entity\CategoryTranslationInterface;
use Sulu\Bundle\CategoryBundle\Entity\CategoryTranslationRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Payload\TaxonPayload;
use Sulu\Bundle\SyliusConsumerBundle\Repository\TaxonCategoryBridgeRepositoryInterface;
use Sulu\Component\Localization\Localization;

class TaxonCategoryAdapter implements TaxonAdapterInterface
{
    /**
     * @var TaxonCategoryBridgeRepositoryInterface
     */
    private $taxonCategoryBridgeRepository;

    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepository;

    /**
     * @var CategoryTranslationRepositoryInterface
     */
    private $categoryTranslationRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(
        TaxonCategoryBridgeRepositoryInterface $taxonCategoryBridgeRepository,
        CategoryRepositoryInterface $categoryRepository,
        CategoryTranslationRepositoryInterface $categoryTranslationRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->taxonCategoryBridgeRepository = $taxonCategoryBridgeRepository;
        $this->categoryRepository = $categoryRepository;
        $this->categoryTranslationRepository = $categoryTranslationRepository;
        $this->entityManager = $entityManager;
    }

    public function synchronize(TaxonPayload $payload): void
    {
        $this->handlePayload($payload);

        // Needed to use categories in other adapters
        // (e.g. category pages with a smart-content filtered by the sylius category)
        $this->entityManager->flush();
    }

    private function handlePayload(TaxonPayload $payload, ?CategoryInterface $parent = null): void
    {
        $bridge = $this->taxonCategoryBridgeRepository->findById($payload->getId());
        if (!$bridge) {
            $category = $this->categoryRepository->createNew();
            $bridge = $this->taxonCategoryBridgeRepository->create($payload->getId(), $category);
            $this->taxonCategoryBridgeRepository->add($bridge);
        }

        $category = $bridge->getCategory();
        $category->setKey($payload->getCode());

        if ($parent) {
            $category->setParent($parent);
        }

        $translations = $payload->getTranslations();
        $category->setDefaultLocale(
            Localization::createFromString(array_key_first($translations), Localization::LCID)->getLocale()
        );

        foreach ($translations as $translationPayload) {
            $locale = $translationPayload->getLocalization()->getLocale();

            /** @var CategoryTranslationInterface|null $categoryTranslation */
            $categoryTranslation = $category->findTranslationByLocale($locale);
            if (!$categoryTranslation) {
                /** @var CategoryTranslationInterface $categoryTranslation */
                $categoryTranslation = $this->categoryTranslationRepository->createNew();
                $category->addTranslation($categoryTranslation);
                $categoryTranslation->setCategory($category);
                $categoryTranslation->setLocale($locale);
            }

            $categoryTranslation->setTranslation($translationPayload->getName());
            $categoryTranslation->setDescription($translationPayload->getDescription());
        }

        foreach ($payload->getChildren() as $child) {
            $this->handlePayload($child, $category);
        }
    }

    public function remove(int $id): void
    {
        $this->taxonCategoryBridgeRepository->removeById($id);
    }
}
