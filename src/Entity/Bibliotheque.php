<?php

namespace App\Entity;

use App\Repository\BibliothequeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: BibliothequeRepository::class)]
#[Broadcast]
class Bibliotheque
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'fk_numero', targetEntity: GestionCours::class, orphanRemoval: true)]
    private Collection $numero_biblio;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $specialite = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    public function __construct()
    {
        $this->numero_biblio = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, GestionCours>
     */
    public function getNumeroBiblio(): Collection
    {
        return $this->numero_biblio;
    }

    public function addNumeroBiblio(GestionCours $numeroBiblio): static
    {
        if (!$this->numero_biblio->contains($numeroBiblio)) {
            $this->numero_biblio->add($numeroBiblio);
            $numeroBiblio->setFkNumero($this);
        }

        return $this;
    }

    public function removeNumeroBiblio(GestionCours $numeroBiblio): static
    {
        if ($this->numero_biblio->removeElement($numeroBiblio)) {
            // set the owning side to null (unless already changed)
            if ($numeroBiblio->getFkNumero() === $this) {
                $numeroBiblio->setFkNumero(null);
            }
        }

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getSpecialite(): ?string
    {
        return $this->specialite;
    }

    public function setSpecialite(string $specialite): static
    {
        $this->specialite = $specialite;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }
}
