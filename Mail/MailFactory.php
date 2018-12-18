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

use Sulu\Bundle\SyliusConsumerBundle\Model\Customer\Customer;
use Sulu\Bundle\WebsiteBundle\Resolver\TemplateAttributeResolver;
use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\Translation\TranslatorInterface;

class MailFactory
{
    /**
     * @var \Swift_Mailer
     */
    protected $mailer;

    /**
     * @var EngineInterface
     */
    protected $engine;

    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * @var TemplateAttributeResolver
     */
    protected $templateAttributeResolver;

    /**
     * @var array
     */
    protected $sender;

    public function __construct(
        \Swift_Mailer $mailer,
        EngineInterface $engine,
        TranslatorInterface $translator,
        array $sender
    ) {
        $this->mailer = $mailer;
        $this->engine = $engine;
        $this->translator = $translator;
        $this->sender = $sender;
    }

    public function sendVerifyEmail(Customer $customer): void
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

        $body = $this->engine->render($template, $data);

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
