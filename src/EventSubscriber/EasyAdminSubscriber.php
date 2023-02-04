<?php

namespace App\EventSubscriber;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class EasyAdminSubscriber implements EventSubscriberInterface
{
    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => ['setUserCreationDateAndHashedPassword',]
        ];
    }

    public function setUserCreationDateAndHashedPassword(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();
        if(!$entity instanceof User){
            return;
        }
        $entity
            ->setCreatedAt(new \DateTimeImmutable('now'))
            ->setPassword($this->userPasswordHasher->hashPassword($entity, $entity->getPassword()));
    }
}