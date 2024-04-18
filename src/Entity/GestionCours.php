<?php

namespace App\Entity;

use App\Repository\GestionCoursRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: GestionCoursRepository::class)]
#[Broadcast]
class GestionCours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $numero_biblio = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(length: 255)]
    private ?string $pdf = null;

    #[ORM\Column(length: 255)]
    private ?string $video = null;

    #[ORM\Column]
    private ?int $nombre_pages = null;

    #[ORM\ManyToOne(inversedBy: 'numero_biblio')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Bibliotheque $fk_numero = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroBiblio(): ?int
    {
        return $this->numero_biblio;
    }

    public function setNumeroBiblio(int $numero_biblio): static
    {
        $this->numero_biblio = $numero_biblio;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getPdf(): ?string
    {
        return $this->pdf;
    }

    public function setPdf(string $pdf): static
    {
        $this->pdf = $pdf;

        return $this;
    }

    public function getVideo(): ?string
    {
        return $this->video;
    }

    public function setVideo(string $video): static
    {
        $this->video = $video;

        return $this;
    }

    public function getNombrePages(): ?int
    {
        return $this->nombre_pages;
    }

    public function setNombrePages(int $nombre_pages): static
    {
        $this->nombre_pages = $nombre_pages;

        return $this;
    }

    public function getFkNumero(): ?Bibliotheque
    {
        return $this->fk_numero;
    }

    public function setFkNumero(?Bibliotheque $fk_numero): static
    {
        $this->fk_numero = $fk_numero;

        return $this;
    }
}

