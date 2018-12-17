<?php

namespace Sulu\Bundle\SyliusConsumerBundle\EventSubscriber;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Customer\Event\CustomerVerifiedEvent;
use Sulu\Bundle\SyliusConsumerBundle\Security\SyliusUser;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Guard\Token\PostAuthenticationGuardToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\SecurityEvents;

final class AutoLoginSubscriber implements EventSubscriberInterface
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * @var string
     */
    private $firewallProviderKey;

    public function __construct(
        TokenStorageInterface $tokenStorage,
        RequestStack $requestStack,
        EventDispatcherInterface $dispatcher,
        string $firewallProviderKey
    ) {
        $this->tokenStorage = $tokenStorage;
        $this->requestStack = $requestStack;
        $this->dispatcher = $dispatcher;
        $this->firewallProviderKey = $firewallProviderKey;
    }


    public static function getSubscribedEvents()
    {
        return [
            CustomerVerifiedEvent::NAME => 'handleCustomerVerified',
        ];
    }

    public function handleCustomerVerified(CustomerVerifiedEvent $event): void
    {
        $user = new SyliusUser($event->getCustomer());

        $token = new PostAuthenticationGuardToken(
            $user,
            $this->firewallProviderKey,
            $user->getRoles()
        );

        $this->tokenStorage->setToken($token);

        $loginEvent = new InteractiveLoginEvent($this->requestStack->getCurrentRequest(), $token);
        $this->dispatcher->dispatch(SecurityEvents::INTERACTIVE_LOGIN, $loginEvent);
    }
}
