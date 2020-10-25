<?php


namespace App\EventListener;

use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\User\UserInterface;

class AuthenticationSuccessListener
{
    /**
     * Adding response data outside of the token
     * @param AuthenticationSuccessEvent $event
     */
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        /** @var User $user */
        $user = $event->getUser();
        $data = $event->getData();

        if (!$user instanceof UserInterface) {
            return;
        }

        $data['firstName'] = $user->getFirstName();
        $data['lastName']  = $user->getLastName();
        $data['email']     = $user->getEmail();

        $event->setData($data);
    }
}
