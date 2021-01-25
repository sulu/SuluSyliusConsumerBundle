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

use Sulu\Bundle\CategoryBundle\Entity\CategoryInterface;
use Sulu\Bundle\CategoryBundle\Entity\CategoryRepositoryInterface;
use Sulu\Bundle\CategoryBundle\Entity\CategoryTranslationInterface;
use Sulu\Bundle\CategoryBundle\Entity\CategoryTranslationRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Payload\TaxonPayload;
use Sulu\Bundle\SyliusConsumerBundle\Repository\TaxonCategoryReferenceRepositoryInterface;
use Sulu\Component\Localization\Localization;

class TaxonCategoryAdapter implements TaxonAdapterInterface
{
    /**
     * @var TaxonCategoryReferenceRepositoryInterface
     */
    private $taxonCategoryReferenceRepository;

    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepository;

    /**
     * @var CategoryTranslationRepositoryInterface
     */
    private $categoryTranslationRepository;

    public function __construct(
        TaxonCategoryReferenceRepositoryInterface $taxonCategoryReferenceRepository,
        CategoryRepositoryInterface $categoryRepository,
        CategoryTranslationRepositoryInterface $categoryTranslationRepository
    ) {
        $this->taxonCategoryReferenceRepository = $taxonCategoryReferenceRepository;
        $this->categoryRepository = $categoryRepository;
        $this->categoryTranslationRepository = $categoryTranslationRepository;
    }

    public function synchronize(TaxonPayload $payload): void
    {
        $this->handlePayload($payload);
    }

    private function handlePayload(TaxonPayload $payload, ?CategoryInterface $parent = null): void
    {
        $reference = $this->taxonCategoryReferenceRepository->findById($payload->getId());
        if (!$reference) {
            $category = $this->categoryRepository->createNew();
            $reference = $this->taxonCategoryReferenceRepository->create($payload->getId(), $category);
            $this->taxonCategoryReferenceRepository->add($reference);
        }

        $category = $reference->getCategory();
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
        $this->taxonCategoryReferenceRepository->removeById($id);
    }
}
