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
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInformationInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductView;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductViewInterface;
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

    public function create(ProductInformationInterface $product, array $dimensions): ProductViewInterface
    {
        $viewProduct = new ProductView($product->getCode());
        $viewProduct->setProductInformation($product);

        $contentDimensions = $this->contentRepository->findByDimensions(
            ProductInterface::RESOURCE_KEY,
            $product->getCode(),
            $dimensions
        );

        $content = $this->contentViewFactory->create($contentDimensions);
        if ($content) {
            $viewProduct->setContent($content);
        }

        $routableResource = $this->routableResourceRepository->findOrCreateByResource(
            ProductInterface::RESOURCE_KEY,
            $product->getCode(),
            $product->getDimension()
        );
        $viewProduct->setRoutableResource($routableResource);

        return $viewProduct;
    }
}
