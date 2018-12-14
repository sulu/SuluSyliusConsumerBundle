<?php

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
    protected $webspacesConfig;

    /**
     * @var string
     */
    protected $adminEmail;

    public function __construct(
        \Swift_Mailer $mailer,
        EngineInterface $engine,
        TranslatorInterface $translator,
        TemplateAttributeResolver $templateAttributeResolver,
        array $webspacesConfig,
        string $adminEmail
    ) {
        $this->mailer = $mailer;
        $this->engine = $engine;
        $this->translator = $translator;
        $this->templateAttributeResolver = $templateAttributeResolver;
        $this->webspacesConfig = $webspacesConfig;
        $this->adminEmail = $adminEmail;
    }

    public function sendConfirmEmail(Customer $customer): void
    {
        if (!$customer->getUser()->getToken()) {
            throw new \RuntimeException('No token given');
        }

        $this->sendEmail(
            [$customer->getEmail() => $customer->getFullName()],
            'email_customer_confirm_subject',
            '@App/email-templates/invitation/new-user.html.twig',
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
        string $locale = null,
        bool $resolve = true
    ): void {
        $translatorLocale = $this->translator->getLocale();

        if ($locale) {
            $this->translator->setLocale($locale);
        }

        if ($resolve) {
            $data = $this->templateAttributeResolver->resolve($data);
        }

        $body = $this->engine->render($template, $data);

        $message = \Swift_Message::newInstance();
        $message->setSubject($this->translator->trans($subject));
        $message->setFrom($this->getFromMails());
        $message->setTo($to);
        $message->setBody($body, 'text/html');

        $this->mailer->send($message);

        $this->translator->setLocale($translatorLocale);
    }

    private function getFromMails(): array
    {
        return $this->webspacesConfig['talentscreen']['from'];
    }
}
