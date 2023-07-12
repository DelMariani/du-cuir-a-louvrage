<?php

namespace App\Entity;

use App\Repository\TrainingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\String\Slugger\SluggerInterface;

#[ORM\Entity(repositoryClass: TrainingRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Training
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $trainTitled = null;

    #[ORM\Column(length: 255)]
    private ?string $trainTopic = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeImmutable $trainDate = null;

    #[ORM\Column]
    private ?int $trainSeat = null;

    #[ORM\Column(length: 255)]
    private ?string $trainPlace = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $slug = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTrainTitled(): ?string
    {
        return $this->trainTitled;
    }

    public function setTrainTitled(string $trainTitled): static
    {
        $this->trainTitled = $trainTitled;

        return $this;
    }

    public function getTrainTopic(): ?string
    {
        return $this->trainTopic;
    }

    public function setTrainTopic(string $trainTopic): static
    {
        $this->trainTopic = $trainTopic;

        return $this;
    }

    public function getTrainDate(): ?\DateTimeImmutable
    {
        return $this->trainDate;
    }

    public function setTrainDate(\DateTimeImmutable $trainDate): static
    {
        $this->trainDate = $trainDate;

        return $this;
    }

    public function getTrainSeat(): ?int
    {
        return $this->trainSeat;
    }

    public function setTrainSeat(int $trainSeat): static
    {
        $this->trainSeat = $trainSeat;

        return $this;
    }

    public function getTrainPlace(): ?string
    {
        return $this->trainPlace;
    }

    public function setTrainPlace(string $trainPlace): static
    {
        $this->trainPlace = $trainPlace;

        return $this;
    }

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

    public function computeSlug(SluggerInterface $slugger)
    {
        if (!$this->slug || '-' === $this->slug){
            $this->slug = (string) $slugger->slug((string) $this->trainTitled)->lower();
        }
    }
}
