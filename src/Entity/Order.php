<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\OneToMany(mappedBy: 'orders', targetEntity: OrderDetail::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $orderDetails;

    public function __construct()
    {
        $this->orderDetails = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, OrderDetail>
     */
    public function getOrderDetails(): Collection
    {
        return $this->orderDetails;
    }

    public function addOrderDetail(OrderDetail $orderDetail): static
    {
        if (!$this->orderDetails->contains($orderDetail)) {
            $this->orderDetails->add($orderDetail);
            $orderDetail->setOrders($this);
        }

        return $this;
    }

    public function removeOrderDetail(OrderDetail $orderDetail): static
    {
        if ($this->orderDetails->removeElement($orderDetail)) {
            // set the owning side to null (unless already changed)
            if ($orderDetail->getOrders() === $this) {
                $orderDetail->setOrders(null);
            }
        }

        return $this;
    }
}
