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

namespace Sulu\Bundle\SyliusConsumerBundle\Controller\Content;

use FOS\RestBundle\Controller\ControllerTrait;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\ViewHandlerInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\Exception\ContentNotFoundException;
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\Message\ModifyContentMessage;
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\Query\FindContentQuery;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Messenger\MessageBusInterface;

abstract class ContentController implements ClassResourceInterface
{
    use ControllerTrait;

    /**
     * @var MessageBusInterface
     */
    private $messageBus;

    /**
     * @var string
     */
    private $defaultType;

    public function __construct(
        MessageBusInterface $messageBus,
        ViewHandlerInterface $viewHandler,
        string $defaultType = 'default'
    ) {
        $this->messageBus = $messageBus;
        $this->defaultType = $defaultType;

        $this->setViewHandler($viewHandler);
    }

    public function cgetAction(): Response
    {
        throw new NotFoundHttpException();
    }

    public function getAction(Request $request, string $resourceId): Response
    {
        try {
            $content = $this->messageBus->dispatch(
                new FindContentQuery($this->getResourceKey(), $resourceId, $request->query->get('locale'))
            );
        } catch (ContentNotFoundException $exception) {
            $content = [
                'template' => $this->defaultType,
            ];
        }

        return $this->handleView($this->view($content));
    }

    public function putAction(Request $request, string $resourceId): Response
    {
        $data = $request->request->all();
        unset($data['template']);
        $payload = [
            'type' => $request->get('template'),
            'data' => $data,
        ];

        $content = $this->messageBus->dispatch(
            new ModifyContentMessage($this->getResourceKey(), $resourceId, $request->query->get('locale'), $payload)
        );

        return $this->handleView($this->view($content));
    }

    abstract protected function getResourceKey(): string;
}
