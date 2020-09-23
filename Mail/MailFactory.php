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

namespace Sulu\Bundle\SyliusConsumerBundle\Mail;

use Sulu\Bundle\SyliusConsumerBundle\Model\Customer\CustomerInterface;
use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Twig\Environment;

class MailFactory
{
    /**
     * @var \Swift_Mailer
     */
    protected $mailer;

    /**
     * @var Environment
     */
    protected $twig;

    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * @var array
     */
    protected $sender;

    public function __construct(
        \Swift_Mailer $mailer,
        Environment $twig,
        TranslatorInterface $translator,
        array $sender
    ) {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->translator = $translator;
        $this->sender = $sender;
    }

    public function sendVerifyEmail(CustomerInterface $customer): void
    {
        if (!$customer->getUser()->getToken()) {
            throw new \RuntimeException('No token given');
        }

        $this->sendEmail(
            [$customer->getEmail() => $customer->getFullName()],
            'sulu_sylius.email_customer_verify.subject',
            'SuluSyliusConsumerBundle:Email:customer-verify.html.twig',
            [
                'customer' => $customer,
                'token' => $customer->getUser()->getToken(),
            ]
        );
    }

    public function sendOrderConfirmationEmail(CustomerInterface $customer, array $order): void
    {
        $this->sendEmail(
            [$customer->getEmail() => $customer->getFullName()],
            'sulu_sylius.email_order-confirmation.subject',
            'SuluSyliusConsumerBundle:Email:order-confirmation.html.twig',
            [
                'customer' => $customer,
                'order' => $order,
            ]
        );
    }

    /**
     * @param string|array $to
     */
    protected function sendEmail(
        $to,
        string $subject,
        string $template,
        array $data = [],
        string $locale = null
    ): void {
        $translatorLocale = $this->translator->getLocale();

        if ($locale) {
            $this->translator->setLocale($locale);
        }

        $body = $this->twig->render($template, $data);

        $message = new \Swift_Message();
        $message->setSubject($this->translator->trans($subject));
        $message->setFrom($this->getFrom());
        $message->setTo($to);
        $message->setBody($body, 'text/html');

        $this->mailer->send($message);

        $this->translator->setLocale($translatorLocale);
    }

    protected function getFrom(): array
    {
        return [
            $this->sender['address'] => $this->sender['name'],
        ];
    }
}
