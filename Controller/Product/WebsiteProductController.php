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

namespace Sulu\Bundle\SyliusConsumerBundle\Controller\Product;

use Sulu\Bundle\HttpCacheBundle\Cache\SuluHttpCache;
use Sulu\Bundle\SyliusConsumerBundle\Model\Attribute\Query\FindAttributeTranslationsByCodesQuery;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductViewInterface;
use Sulu\Bundle\SyliusConsumerBundle\Resolver\ProductViewContentResolverInterface;
use Sulu\Bundle\WebsiteBundle\Resolver\TemplateAttributeResolverInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;

class WebsiteProductController extends AbstractController
{
    /**
     * @var ProductViewContentResolverInterface
     */
    private $productViewContentResolver;

    /**
     * @var TemplateAttributeResolverInterface
     */
    private $templateAttributesResolver;

    public function __construct(
        ProductViewContentResolverInterface $productViewContentResolver,
        TemplateAttributeResolverInterface $templateAttributesResolver
    ) {
        $this->productViewContentResolver = $productViewContentResolver;
        $this->templateAttributesResolver = $templateAttributesResolver;
    }

    public function indexAction(Request $request, ProductViewInterface $object, string $view): Response
    {
        return $this->renderProduct($request, $object, $view);
    }

    protected function renderProduct(
        Request $request,
        ProductViewInterface $object,
        string $view,
        array $attributes = []
    ): Response {
        $requestFormat = $request->getRequestFormat();
        $viewTemplate = $view . '.' . $requestFormat . '.twig';

        return $this->render(
            $viewTemplate,
            $this->getAttributes($attributes, $object, $request->getLocale()),
            $this->createResponse($request)
        );
    }

    protected function getAttributes(array $attributes, ProductViewInterface $object, string $locale): array
    {
        $attributes = $this->getAttributeResolver()->resolve(
            array_merge($this->resolveProductView($object), $attributes)
        );

        return array_merge($attributes, $this->resolveProductAttributes($object, $locale));
    }

    protected function resolveProductAttributes(ProductViewInterface $object, string $locale): array
    {
        $attributeValueCodes = $object->getProductInformation()->getAttributeValueCodes();
        if (!$attributeValueCodes) {
            return [];
        }

        $query = new FindAttributeTranslationsByCodesQuery($locale, $attributeValueCodes);
        $this->getMessageBus()->dispatch($query);

        return [
            'productAttributeTranslations' => $query->getProductAttributeTranslations(),
        ];
    }

    protected function resolveProductView(ProductViewInterface $object): array
    {
        /** @var array $result */
        $result = $this->getProductViewResolver()->resolve($object);

        return $result;
    }

    protected function getAttributeResolver(): TemplateAttributeResolverInterface
    {
        return $this->templateAttributesResolver;
    }

    protected function createResponse(Request $request)
    {
        $response = new Response();
        $cacheLifetime = $request->attributes->get('_cacheLifetime');

        if ($cacheLifetime) {
            $response->setPublic();
            $response->headers->set(
                SuluHttpCache::HEADER_REVERSE_PROXY_TTL,
                $cacheLifetime
            );
            $response->setMaxAge($this->getContainer()->getParameter('sulu_http_cache.cache.max_age'));
            $response->setSharedMaxAge($this->getContainer()->getParameter('sulu_http_cache.cache.shared_max_age'));
        }

        return $response;
    }

    protected function getProductViewResolver(): ProductViewContentResolverInterface
    {
        return $this->productViewContentResolver;
    }

    protected function getMessageBus(): MessageBusInterface
    {
        /** @var MessageBusInterface $messageBus */
        $messageBus = $this->get('message_bus');

        return $messageBus;
    }

    protected function getContainer(): ContainerInterface
    {
        /** @var ContainerInterface $container */
        $container = $this->container;

        return $container;
    }
}
