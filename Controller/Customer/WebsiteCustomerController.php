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
use Sulu\Bundle\SyliusConsumerBundle\Model\Customer\Message\VerifyCustomerByTokenMessage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;

class WebsiteCustomerController extends AbstractController
{
    /**
     * @var MessageBusInterface
     */
    private $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function verify(string $token): Response
    {
        try {
            $this->messageBus->dispatch(new VerifyCustomerByTokenMessage($token));
        } catch (TokenNotFoundException $tokenNotFoundException) {
            throw $this->createNotFoundException('Token not found');
        }

        return $this->redirect('/');
    }
}