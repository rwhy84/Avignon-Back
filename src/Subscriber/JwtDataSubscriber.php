<?php

namespace App\Subscriber;



use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class JwtDataSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return [
            Events::JWT_CREATED => 'addId'
        ];
    }


    public function addId(JWTCreatedEvent $event)
    {
        /** @var \App\Entity\User */
        $user = $event->getUser();
        $data = $event->getData();

        $data['id'] = $user->getId();
        $event->setData($data);
    }
}
