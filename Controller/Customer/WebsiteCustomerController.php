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
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class WebsiteCustomerController
{
    /**
     * @var MessageBusInterface
     */
    private $messageBus;

    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * @var string
     */
    private $redirectTo;

    public function __construct(
        MessageBusInterface $messageBus,
        UrlGeneratorInterface $urlGenerator,
        string $redirectTo
    ) {
        $this->messageBus = $messageBus;
        $this->urlGenerator = $urlGenerator;
        $this->redirectTo = $redirectTo;
    }

    public function verify(Request $request, string $token): Response
    {
        try {
            $this->messageBus->dispatch(new VerifyCustomerMessage($token));
        } catch (TokenNotFoundException $tokenNotFoundException) {
            throw new NotFoundHttpException('Token not found', $tokenNotFoundException);
        }

        if (0 === strpos($this->redirectTo, '/')) {
            $url = str_replace('{localization}', $request->getLocale(), $this->redirectTo);
        } else {
            $url = $this->urlGenerator->generate($this->redirectTo);
        }

        return new RedirectResponse($url, 302);
    }
}
