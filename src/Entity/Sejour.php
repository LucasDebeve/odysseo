<?php

namespace App\Entity;

use App\Repository\SejourRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SejourRepository::class)]
class Sejour
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $dateDebut = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $dateFin = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $capaciteAccueil = 0;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebut(): ?\DateTimeImmutable
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeImmutable $dateDebut): static
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeImmutable
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeImmutable $dateFin): static
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getCapaciteAccueil(): ?int
    {
        return $this->capaciteAccueil;
    }

    public function setCapaciteAccueil(int $capaciteAccueil): static
    {
        $this->capaciteAccueil = $capaciteAccueil;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getStatut(): string
    {
        $now = new \DateTime();
        if ($this->dateDebut > $now) return 'À venir';
        if ($this->dateFin < $now) return 'Terminé';
        return 'En cours';
    }

    public function getSaison(): string
    {
        $mois = (int)$this->dateDebut->format('m');
        if (in_array($mois, [6, 7, 8])) return 'ÉTÉ ' . $this->dateDebut->format('Y');
        if (in_array($mois, [12, 1, 2])) return 'HIVER ' . $this->dateDebut->format('Y');
        return 'PRINTEMPS ' . $this->dateDebut->format('Y');
    }

    public function getEquipe(): ArrayCollection
    {
        return new ArrayCollection([]);
    }

    public function getEnfants(): ArrayCollection
    {
        return new ArrayCollection([]);
    }

    public function getPourcentageRemplissage(): int
    {
        if ($this->capaciteAccueil <= 0) return 0;
        return (int)(($this->getEnfants()->count() / $this->capaciteAccueil) * 100);
    }
}
