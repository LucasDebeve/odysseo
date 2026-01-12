<?php

namespace App\Entity;

use App\Repository\EnfantSejourRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EnfantSejourRepository::class)]
class EnfantSejour
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'enfants')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Sejour $sejour = null;

    #[ORM\ManyToOne(inversedBy: 'participations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $enfant = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSejour(): ?Sejour
    {
        return $this->sejour;
    }

    public function setSejour(?Sejour $sejour): static
    {
        $this->sejour = $sejour;

        return $this;
    }

    public function getEnfant(): ?User
    {
        return $this->enfant;
    }

    public function setEnfant(?User $enfant): static
    {
        $this->enfant = $enfant;

        return $this;
    }
}
