<?php

namespace App\EventSubscriber;

use App\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PasswordHashSubscriber implements EventSubscriberInterface
{

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    public function onKernelView(ViewEvent $event)
    {

        $user = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$user instanceof User || Request::METHOD_POST !== $method) {

            return;
        }

        $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()));
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.view' => 'onKernelView',
        ];
    }
}
