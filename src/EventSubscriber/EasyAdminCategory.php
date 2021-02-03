<?php

namespace App\EventSubscriber;

use App\Entity\Category;
use App\Service\Slugify;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;

class EasyAdminCategory implements EventSubscriberInterface
{
    private $slugger;

    public function __construct(Slugify $slugger)
    {
        $this->slugger = $slugger;
    }

    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => ['setCategorySlug'],
            BeforeEntityUpdatedEvent::class => ['updateCategorySlug']
        ];
    }

    public function setCategorySlug(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if (!($entity instanceof Category)) {
            return;
        }

        $slug = $this->slugger->generate($entity->getName());
        $entity->setSlug($slug);
    }

    public function updateCategorySlug(BeforeEntityUpdatedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if (!($entity instanceof Category)) {
            return;
        }

        $slug = $this->slugger->generate($entity->getName());
        $entity->setSlug($slug);
    }
}