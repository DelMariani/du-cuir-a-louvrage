<?php

namespace App\EntityListener;

use App\Entity\Training;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\String\Slugger\SluggerInterface;

#[AsEntityListener(event: Events::prePersist, entity: Training::class)]
#[AsEntityListener(event: Events::preUpdate, entity: Training::class)]
class TrainingEntityListener
{
    public function __construct(
        private SluggerInterface $slugger,
    ) {
    }

    public function prePersist(Training $training, LifecycleEventArgs $event)
    {
        $training->computeSlug($this->slugger);
    }

    public function preUpdate(Training $training, LifecycleEventArgs $event)
    {
        $training->computeSlug($this->slugger);
    }
}
