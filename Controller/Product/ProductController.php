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

        $this->messageBus->dispatch(
            new ModifyProductMessage($id, $locale, $request->request->all())
        );

        $product = $this->messageBus->dispatch(new FindProductQuery($id, $request->query->get('locale')));

        return $this->handleView($this->view($product));
    }

    public function cgetAction(Request $request): Response
    {
        $listResult = $this->messageBus->dispatch(
            new ListProductsQuery(
                $request->query->get('locale'),
                $request->get('_route'),
                $request->query->all()
            )
        );

        return $this->handleView($this->view($listResult));
    }

    public function getAction(Request $request, string $id): Response
    {
        $product = $this->messageBus->dispatch(new FindProductQuery($id, $request->query->get('locale')));

        return $this->handleView($this->view($product));
    }
}
