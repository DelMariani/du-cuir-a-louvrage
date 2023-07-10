<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $catNaming = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $catDescribe = null;

    #[ORM\OneToMany(mappedBy: 'pceCategory', targetEntity: Piece::class)]
    private Collection $pieces;

    public function __construct()
    {
        $this->pieces = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCatNaming(): ?string
    {
        return $this->catNaming;
    }

    public function setCatNaming(string $catNaming): static
    {
        $this->catNaming = $catNaming;

        return $this;
    }

    public function getCatDescribe(): ?string
    {
        return $this->catDescribe;
    }

    public function setCatDescribe(string $catDescribe): static
    {
        $this->catDescribe = $catDescribe;

        return $this;
    }

    /**
     * @return Collection<int, Piece>
     */
    public function getPieces(): Collection
    {
        return $this->pieces;
    }

    public function addPiece(Piece $piece): static
    {
        if (!$this->pieces->contains($piece)) {
            $this->pieces->add($piece);
            $piece->setPceCategory($this);
        }

        return $this;
    }

    public function removePiece(Piece $piece): static
    {
        if ($this->pieces->removeElement($piece)) {
            // set the owning side to null (unless already changed)
            if ($piece->getPceCategory() === $this) {
                $piece->setPceCategory(null);
            }
        }

        return $this;
    }
}
