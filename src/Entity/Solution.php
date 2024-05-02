<?php

namespace App\Entity;

use App\Repository\SolutionRepository;
use App\Entity\Reclamation;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SolutionRepository::class)]
class Solution
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $contenusolution = null;

    #[ORM\Column(length: 255)]
    private ?string $nomadmin = null;

    // Define Many-to-One relationship with Reclamation entity
    #[ORM\ManyToOne(targetEntity: Reclamation::class)]
    #[ORM\JoinColumn(name: 'idreclamation', referencedColumnName: 'id')]
    private ?Reclamation $reclamation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenusolution(): ?string
    {
        return $this->contenusolution;
    }

    public function setContenusolution(string $contenusolution): static
    {
        $this->contenusolution = $contenusolution;

        return $this;
    }

    public function getNomadmin(): ?string
    {
        return $this->nomadmin;
    }

    public function setNomadmin(string $nomadmin): static
    {
        $this->nomadmin = $nomadmin;

        return $this;
    }

    public function getReclamation(): ?Reclamation
    {
        return $this->reclamation;
    }

    public function setReclamation(?Reclamation $reclamation): static
    {
        $this->reclamation = $reclamation;

        return $this;
    }
}