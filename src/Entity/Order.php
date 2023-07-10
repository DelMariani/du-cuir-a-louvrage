<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $ordNumber = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $ordDate = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrdNumber(): ?string
    {
        return $this->ordNumber;
    }

    public function setOrdNumber(string $ordNumber): static
    {
        $this->ordNumber = $ordNumber;

        return $this;
    }

    public function getOrdDate(): ?\DateTimeImmutable
    {
        return $this->ordDate;
    }

    public function setOrdDate(\DateTimeImmutable $ordDate): static
    {
        $this->ordDate = $ordDate;

        return $this;
    }
}
