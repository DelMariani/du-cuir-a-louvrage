<?php

namespace App\Entity;

use App\Repository\OrderDetailRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderDetailRepository::class)]
class OrderDetail
{
    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'orderDetails')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Order $orders = null;

    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'orderDetails')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Piece $pieces = null;

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getOrders(): ?Order
    {
        return $this->orders;
    }

    public function setOrders(?Order $orders): static
    {
        $this->orders = $orders;

        return $this;
    }

    public function getPieces(): ?Piece
    {
        return $this->pieces;
    }

    public function setPieces(?Piece $pieces): static
    {
        $this->pieces = $pieces;

        return $this;
    }
}