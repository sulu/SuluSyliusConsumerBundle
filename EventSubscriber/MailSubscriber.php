<?php

namespace Sulu\Bundle\SyliusConsumerBundle\EventSubscriber;

use AppBundle\Mail\MailFactory;
use AppBundle\Model\Casting\Event\MemberCreated;
use AppBundle\Model\Production\Event\InvitationAccepted;
use AppBundle\Model\Production\Event\InvitationCreated;
use AppBundle\Model\Production\Event\InvitationDeclined;
use AppBundle\Model\Production\Event\InvitationResent;
use AppBundle\Model\Production\Event\MemberRemoved;
use AppBundle\Model\Production\Event\ProductionDeclined;
use AppBundle\Model\Production\Event\ProductionSubmitted;
use AppBundle\Model\User\Contact;
use AppBundle\Model\User\Event\ProofOfAgeAccepted;
use AppBundle\Model\User\User;
use Sulu\Bundle\CommunityBundle\Event\CommunityEvent;
use Sulu\Bundle\CommunityBundle\Manager\CommunityManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MailSubscriber implements EventSubscriberInterface
{
    /**
     * @var MailFactory
     */
    protected $mailFactory;

    public function __construct(MailFactory $mailFactory)
    {
        $this->mailFactory = $mailFactory;
    }

    public static function getSubscribedEvents()
    {
        return [
            InvitationCreated::NAME => 'handleInvitationCreated',
            InvitationResent::NAME => 'handleInvitationResent',
            InvitationAccepted::NAME => 'handleInvitationAccepted',
            InvitationDeclined::NAME => 'handleInvitationDeclined',
            MemberRemoved::NAME => 'handleMemberRemoved',
            CommunityManager::EVENT_COMPLETED => 'handleUserCompleted',
            ProofOfAgeAccepted::NAME => 'handleProofOfAgeAccepted',
            MemberCreated::NAME => 'handleCastingMemberCreated',
            ProductionSubmitted::NAME => 'handleProductionSubmitted',
            ProductionDeclined::NAME => 'handleProductionDeclined',
        ];
    }

    public function handleInvitationCreated(InvitationCreated $event): void
    {
        $this->mailFactory->sendInvitation($event->getInvitation());
    }

    public function handleInvitationResent(InvitationResent $event): void
    {
        $this->mailFactory->sendInvitation($event->getInvitation());
    }

    public function handleInvitationAccepted(InvitationAccepted $event): void
    {
        $this->mailFactory->sendInvitationAcceptedOwner($event->getInvitation());
    }

    public function handleInvitationDeclined(InvitationDeclined $event): void
    {
        $this->mailFactory->sendInvitationDeclinedOwner($event->getInvitation());
        $this->mailFactory->sendInvitationDeclinedUser($event->getInvitation());
    }

    public function handleMemberRemoved(MemberRemoved $event): void
    {
        $this->mailFactory->sendMemberRemoved($event->getMember());
    }

    public function handleProductionSubmitted(ProductionSubmitted $event)
    {
        $this->mailFactory->sendProductionSubmitted($event->getProduction());
    }

    public function handleProductionDeclined(ProductionDeclined $event)
    {
        $this->mailFactory->sendProductionDeclined($event->getProduction());
    }

    public function handleUserCompleted(CommunityEvent $event): void
    {
        /** @var User $user */
        $user = $event->getUser();
        /** @var Contact $contact */
        $contact = $user->getContact();
        if ($contact->isProofOfAge()) {
            $this->mailFactory->sendProofOfAge($user);
        }
    }

    public function handleProofOfAgeAccepted(ProofOfAgeAccepted $event): void
    {
        $this->mailFactory->sendProofOfAgeAccepted($event->getUser());
    }

    public function handleCastingMemberCreated(MemberCreated $event): void
    {
        $this->mailFactory->sendCastingMemberCreated($event->getMember());
    }
}
