<?php

namespace App\EventSubscriber;

use App\Entity\Reservation;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ReservationEventSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => ['setReservationCreationDate'],
        ];
    }

    public function setReservationCreationDate(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if(!$entity instanceof Reservation){
            return;
        }
        $entity->setCreatedAt(new \DateTimeImmutable('now'));
    }

}