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

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\ViewHandlerInterface;
use Sulu\Bundle\SyliusConsumerBundle\Controller\Content\ContentController;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * @Rest\RouteResource("product-content")
 */
class ProductContentController extends ContentController
{
    public function __construct(
        MessageBusInterface $messageBus,
        ViewHandlerInterface $viewHandler,
        string $defaultType = 'default'
    ) {
        parent::__construct($messageBus, $viewHandler, 'products', $defaultType);
    }
}
