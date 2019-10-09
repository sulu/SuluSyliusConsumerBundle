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

namespace Sulu\Bundle\SyliusConsumerBundle\Resolver;

use Sulu\Bundle\RouteBundle\Entity\Route;
use Sulu\Bundle\RouteBundle\Entity\RouteRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\ContentViewInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductViewInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\RoutableResource\RoutableResource;
use Sulu\Component\Content\Compat\StructureInterface;
use Sulu\Component\Content\Compat\StructureManagerInterface;
use Sulu\Component\Content\ContentTypeManagerInterface;
use Sulu\Component\Serializer\ArraySerializerInterface;
use Sulu\Component\Webspace\Analyzer\Attributes\RequestAttributes;
use Sulu\Component\Webspace\Webspace;
use Symfony\Component\HttpFoundation\RequestStack;

class ProductViewContentResolver implements ProductViewContentResolverInterface
{
    /**
     * @var StructureManagerInterface
     */
    private $structureManager;

    /**
     * @var ArraySerializerInterface
     */
    private $arraySerializer;

    /**
     * @var RouteRepositoryInterface
     */
    private $routeRepository;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var ContentTypeManagerInterface
     */
    private $contentTypeManager;

    public function __construct(
        StructureManagerInterface $structureManager,
        ArraySerializerInterface $arraySerializer,
        RouteRepositoryInterface $routeRepository,
        RequestStack $requestStack,
        ContentTypeManagerInterface $contentTypeManager
    ) {
        $this->structureManager = $structureManager;
        $this->arraySerializer = $arraySerializer;
        $this->routeRepository = $routeRepository;
        $this->requestStack = $requestStack;
        $this->contentTypeManager = $contentTypeManager;
    }

    public function resolve(ProductViewInterface $productView): array
    {
        $content = $productView->getContent();
        $structure = $content ? $this->getStructure($productView, $content) : null;
        $contentData = $content ? $content->getData() : [];

        return [
            'locale' => $productView->getLocale(),
            'id' => $productView->getProduct()->getId(),
            'product' => $this->getProductData($productView),
            'extension' => [/* TODO seo and excerpt */],
            'urls' => $this->getUrls($productView),
            'content' => $structure ? $this->resolveContent($structure, $contentData) : null,
            'view' => $structure ? $this->resolveView($structure, $contentData) : null,
            'template' => $structure ? $structure->getKey() : null,
            'routePath' => $productView->getRoutePath(),
        ];
    }

    private function getStructure(ProductViewInterface $productView, ContentViewInterface $contentView): ?StructureInterface
    {
        $contentType = $contentView->getType();
        if (!$contentType) {
            return null;
        }

        $structure = $this->structureManager->getStructure($contentType, ProductInterface::CONTENT_RESOURCE_KEY);
        $structure->setLanguageCode($productView->getLocale());

        return $structure;
    }

    protected function getProductData(ProductViewInterface $productView): array
    {
        $productData = $this->arraySerializer->serialize($productView->getProduct());
        $productInformationData = $this->arraySerializer->serialize($productView->getProductInformation());

        $data = array_merge(
            $productData,
            $productInformationData
        );

        $data['mainCategory'] = $productView->getMainCategory();
        $data['categories'] = $productView->getCategories();
        $data['media'] = $productView->getMedia();

        if (!array_key_exists('customData', $productData)) {
            $productData['customData'] = [];
        }
        if (!array_key_exists('customData', $productInformationData)) {
            $productInformationData['customData'] = [];
        }
        $data['customData'] = array_merge_recursive($productData['customData'], $productInformationData['customData']);

        return $data;
    }

    private function getUrls(ProductViewInterface $productView): array
    {
        $urls = [];
        $request = $this->requestStack->getCurrentRequest();
        if (!$request) {
            return $urls;
        }

        /** @var RequestAttributes|null $attributes */
        $attributes = $request->get('_sulu');
        if (!$attributes) {
            return $urls;
        }

        /** @var Webspace|null $webspace */
        $webspace = $attributes->getAttribute('webspace');
        if (!$webspace) {
            return $urls;
        }

        foreach ($webspace->getAllLocalizations() as $localization) {
            $locale = $localization->getLocale();

            /** @var Route|null $route */
            $route = $this->routeRepository->findByEntity(RoutableResource::class, $productView->getId(), $locale);

            $urls[$locale] = '/';
            if ($route) {
                $urls[$locale] = $route->getPath();
            }
        }

        return $urls;
    }

    private function resolveContent(StructureInterface $structure, array $data)
    {
        $content = [];
        foreach ($structure->getProperties(true) as $child) {
            if (array_key_exists($child->getName(), $data)) {
                $child->setValue($data[$child->getName()]);
            }

            $contentType = $this->contentTypeManager->get($child->getContentTypeName());
            $content[$child->getName()] = $contentType->getContentData($child);
        }

        return $content;
    }

    private function resolveView(StructureInterface $structure, array $data): array
    {
        $view = [];
        foreach ($structure->getProperties(true) as $child) {
            if (array_key_exists($child->getName(), $data)) {
                $child->setValue($data[$child->getName()]);
            }

            $contentType = $this->contentTypeManager->get($child->getContentTypeName());
            $view[$child->getName()] = $contentType->getViewData($child);
        }

        return $view;
    }
}
