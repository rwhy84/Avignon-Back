<?php

namespace App\Doctrine\Subscriber;

use App\Entity\Event;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;

class EventCreateListener
{


    protected Security $security;


    public function __construct(Security $security)
    {

        $this->security = $security;
    }

    public function prePersist(Event $event)
    {
        /** @var User */
        $user = $this->security->getUser();
        $event->setEtablissement($user->getEtablissement());
    }
}
