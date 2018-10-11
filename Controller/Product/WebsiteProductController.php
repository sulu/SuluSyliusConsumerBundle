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
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductViewInterface;
use Sulu\Bundle\WebsiteBundle\Resolver\TemplateAttributeResolverInterface;
use Symfony\Bundle\FrameworkBundle\Controller\ControllerTrait;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class WebsiteProductController implements ContainerAwareInterface
{
    use ContainerAwareTrait;
    use ControllerTrait;

    public function indexAction(Request $request, ProductViewInterface $object, string $view): Response
    {
        $requestFormat = $request->getRequestFormat();
        $viewTemplate = $view . '.' . $requestFormat . '.twig';

        return $this->render(
            $viewTemplate,
            $this->getAttributeResolver()->resolve(['product' => $object]),
            $this->createResponse($request)
        );
    }

    protected function getAttributeResolver(): TemplateAttributeResolverInterface
    {
        /** @var TemplateAttributeResolverInterface $resolver */
        $resolver = $this->get('sulu_website.resolver.template_attribute');

        return $resolver;
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
            $response->setMaxAge($this->container->getParameter('sulu_http_cache.cache.max_age'));
            $response->setSharedMaxAge($this->container->getParameter('sulu_http_cache.cache.shared_max_age'));
        }

        return $response;
    }
}
