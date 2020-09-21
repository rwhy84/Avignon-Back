<?php

namespace App\Doctrine\Subscriber;

use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserPasswordListener
{

    protected UserPasswordEncoderInterface $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function prePersist(User $user)
    {
        $password = $user->getPassword();
        $encoded = $this->encoder->encodePassword($user, $password);

        $user->setPassword($encoded);

        if ($user->getEtablissement() !== null) {
            $user->setRoles(['ROLE_PRO']);
        }
    }
}
