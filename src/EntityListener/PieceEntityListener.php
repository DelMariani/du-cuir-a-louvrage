<?php

namespace App\EntityListener;

use App\Entity\Piece;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\String\Slugger\SluggerInterface;

#[AsEntityListener(event: Events::prePersist, entity: Piece::class)]
#[AsEntityListener(event: Events::preUpdate, entity: Piece::class)]
class PieceEntityListener
{
    public function __construct(
        private SluggerInterface $slugger,
    ) {
    }

    public function prePersist(Piece $piece, LifecycleEventArgs $event)
    {
        $piece->computeSlug($this->slugger);
    }

    public function preUpdate(Piece $piece, LifecycleEventArgs $event)
    {
        $piece->computeSlug($this->slugger);
    }
}
