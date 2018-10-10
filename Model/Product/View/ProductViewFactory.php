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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Product\View;

use Sulu\Bundle\SyliusConsumerBundle\Model\Content\ContentRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\View\ContentViewFactoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Product;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\RoutableResource\RoutableResourceRepositoryInterface;

class ProductViewFactory implements ProductViewFactoryInterface
{
    /**
     * @var ContentRepositoryInterface
     */
    private $contentRepository;

    /**
     * @var RoutableResourceRepositoryInterface
     */
    private $routableResourceRepository;

    /**
     * @var ContentViewFactoryInterface
     */
    private $contentViewFactory;

    public function __construct(
        ContentRepositoryInterface $contentRepository,
        RoutableResourceRepositoryInterface $routableResourceRepository,
        ContentViewFactoryInterface $contentViewFactory
    ) {
        $this->contentRepository = $contentRepository;
        $this->routableResourceRepository = $routableResourceRepository;
        $this->contentViewFactory = $contentViewFactory;
    }

    public function create(array $productDimensions, array $dimensions): ProductInterface
    {
        $firstProductDimension = reset($productDimensions);

        $product = new Product(
            $firstProductDimension->getDimension(),
            $firstProductDimension->getCode(),
            $firstProductDimension->getVariants()
        );

        $contentDimensions = $this->contentRepository->findByDimensions('products', $product->getCode(), $dimensions);
        $content = $this->contentViewFactory->create($contentDimensions);
        if ($content) {
            $product->setContent($content);
        }

        $routable = $this->routableResourceRepository->findOrCreateByResource(
            'products',
            $product->getCode(),
            $product->getDimension()
        );
        $product->setRoutable($routable);

        return $product;
    }
}
