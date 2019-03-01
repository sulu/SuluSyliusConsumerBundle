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

use FOS\RestBundle\Controller\ControllerTrait;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\ViewHandlerInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\ModifyProductMessage;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Query\FindProductQuery;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Query\ListProductsQuery;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;

class ProductController implements ClassResourceInterface
{
    use ControllerTrait;

    /**
     * @var MessageBusInterface
     */
    private $messageBus;

    public function __construct(MessageBusInterface $messageBus, ViewHandlerInterface $viewHandler)
    {
        $this->messageBus = $messageBus;

        $this->setViewHandler($viewHandler);
    }

    public function putAction(Request $request, string $id): Response
    {
        $locale = $request->query->get('locale');

        $message = new ModifyProductMessage($id, $locale, $request->request->all());
        $this->messageBus->dispatch($message);

        $message = new FindProductQuery($id, $request->query->get('locale'));
        $this->messageBus->dispatch($message);
        $product = $message->getProduct();

        return $this->handleView($this->view($product));
    }

    public function cgetAction(Request $request): Response
    {
        $query = new ListProductsQuery($request->query->get('locale'), $request->get('_route'), $request->query->all());
        $this->messageBus->dispatch($query);
        $products = $query->getProducts();

        return $this->handleView($this->view($products));
    }

    public function getAction(Request $request, string $id): Response
    {
        $message = new FindProductQuery($id, $request->query->get('locale'));
        $this->messageBus->dispatch($message);
        $product = $message->getProduct();

        return $this->handleView($this->view($product));
    }
}
