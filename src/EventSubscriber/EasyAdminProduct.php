<?php

namespace App\EventSubscriber;

use App\Entity\Product;
use App\Service\Slugify;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;

class EasyAdminProduct implements EventSubscriberInterface
{
    private $slugger;

    public function __construct(Slugify $slugger)
    {
        $this->slugger = $slugger;
    }

    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => ['setProductSlug'],
            BeforeEntityUpdatedEvent::class => ['updateProductSlug']
        ];
    }

    public function setProductSlug(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if (!($entity instanceof Product)) {
            return;
        }

        $slug = $this->slugger->generate($entity->getName());
        $entity->setSlug($slug);
    }

    public function updateProductSlug(BeforeEntityUpdatedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if (!($entity instanceof Product)) {
            return;
        }

        $slug = $this->slugger->generate($entity->getName());
        $entity->setSlug($slug);
    }
}