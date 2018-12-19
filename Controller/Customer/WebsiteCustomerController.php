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

namespace Sulu\Bundle\SyliusConsumerBundle\Controller\Customer;

use Sulu\Bundle\SyliusConsumerBundle\Model\Customer\Exception\TokenNotFoundException;
use Sulu\Bundle\SyliusConsumerBundle\Model\Customer\Message\VerifyCustomerMessage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;

class WebsiteCustomerController extends AbstractController
{
    /**
     * @var MessageBusInterface
     */
    private $messageBus;

    /**
     * @var Router
     */
    private $router;

    /**
     * @var string
     */
    private $redirectTo;

    public function __construct(MessageBusInterface $messageBus, Router $router, string $redirectTo)
    {
        $this->messageBus = $messageBus;
        $this->router = $router;
        $this->redirectTo = $redirectTo;
    }

    public function verify(Request $request, string $token): Response
    {
        try {
            $this->messageBus->dispatch(new VerifyCustomerMessage($token));
        } catch (TokenNotFoundException $tokenNotFoundException) {
            throw $this->createNotFoundException('Token not found');
        }

        if (0 === strpos($this->redirectTo, '/')) {
            $url = str_replace('{localization}', $request->getLocale(), $this->redirectTo);
        } else {
            $url = $this->router->generate($this->redirectTo);
        }

        return $this->redirect($url);
    }
}
