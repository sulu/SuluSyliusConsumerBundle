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

use Sulu\Bundle\MediaBundle\Entity\MediaRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Exception\ProductNotFoundException;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\ModifyProductMessage;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductMediaReferenceRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductRepositoryInterface;

class ModifyProductMessageHandler
{
    /**
     * @var MediaRepositoryInterface
     */
    private $mediaRepository;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var ProductMediaReferenceRepositoryInterface
     */
    private $productMediaReferenceRepository;

    public function __construct(
        MediaRepositoryInterface $mediaRepository,
        ProductRepositoryInterface $productRepository,
        ProductMediaReferenceRepositoryInterface $productMediaReferenceRepository
    ) {
        $this->mediaRepository = $mediaRepository;
        $this->productRepository = $productRepository;
        $this->productMediaReferenceRepository = $productMediaReferenceRepository;
    }

    public function __invoke(ModifyProductMessage $message): ProductInterface
    {
        $product = $this->productRepository->findById($message->getId());
        if (!$product) {
            throw new ProductNotFoundException($message->getId());
        }

        $sorting = 1;
        foreach ($message->getMediaReferences() as $mediaReferenceValueObject) {
            $mediaReference = $product->findMediaReferenceByMediaId($mediaReferenceValueObject->getMediaId());
            if (!$mediaReference) {
                $media = $this->mediaRepository->find($mediaReferenceValueObject->getMediaId());
                $mediaReference = $this->productMediaReferenceRepository->create(
                    $product,
                    $media,
                    $mediaReferenceValueObject->getType()
                );
            }

            if ($mediaReference->getSyliusId()) {
                $mediaReference->setActive($mediaReferenceValueObject->getActive());
            } else {
                $mediaReference->setType($mediaReferenceValueObject->getType());
            }

            $mediaReference->setSorting($sorting);
        }

        // TODO: Check for deleted

        return $product;
    }
}
