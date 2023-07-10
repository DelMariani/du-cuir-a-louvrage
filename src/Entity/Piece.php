<?php

namespace App\Entity;

use App\Repository\PieceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\String\Slugger\SluggerInterface;

#[ORM\Entity(repositoryClass: PieceRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Piece
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $pceName = null;

    #[ORM\Column(length: 50)]
    private ?string $pceColor = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $pcePrice = null;

    #[ORM\ManyToOne(inversedBy: 'pieces')]
    private ?Category $pceCategory = null;

    #[ORM\Column(length: 255)]
    private ?string $pcePhoto = null;

    #[ORM\Column(length: 255)]
    private ?string $slug=null;
    public function computeSlug(SluggerInterface $slugger)
    {
        if (!$this->slug || '-' === $this->slug) {
            $this->slug = $slugger->slug((string) $this->pceName)->lower();
        }
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPceName(): ?string
    {
        return $this->pceName;
    }

    public function setPceName(string $pceName): static
    {
        $this->pceName = $pceName;

        return $this;
    }

    public function getPceColor(): ?string
    {
        return $this->pceColor;
    }

    public function setPceColor(string $pceColor): static
    {
        $this->pceColor = $pceColor;

        return $this;
    }

    public function getPcePrice(): ?string
    {
        return $this->pcePrice;
    }

    public function setPcePrice(string $pcePrice): static
    {
        $this->pcePrice = $pcePrice;

        return $this;
    }

    public function getPceCategory(): ?Category
    {
        return $this->pceCategory;
    }

    public function setPceCategory(?Category $pceCategory): static
    {
        $this->pceCategory = $pceCategory;

        return $this;
    }

    public function getPcePhoto(): ?string
    {
        return $this->pcePhoto;
    }

    public function setPcePhoto(string $pcePhoto): static
    {
        $this->pcePhoto = $pcePhoto;

        return $this;
    }

    public function setPhotoFile(?File $photoFile = null): void
    {
        $this->photoFile= $photoFile;
    }
    public function getPhotoFile() : ?File
    {
        return $this->photoFile;
    }


    /**
     * @return string|null
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @param string|null $slug
     */
    public function setSlug(?string $slug): void
    {
        $this->slug = $slug;
    }


}