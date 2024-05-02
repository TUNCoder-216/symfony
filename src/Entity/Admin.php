<?php

namespace App\Entity;

use App\Repository\AdminRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Form\FileType;

#[ORM\Entity(repositoryClass: AdminRepository::class)]
class Admin
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Email(message:"Entrez une adresse email valide")]
    #[Assert\NotBlank(message:"Veuillez remplir ce champ")]
    private ?string $emailAdmin = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Veuillez remplir ce champ")]
    private ?string $nomAdmin = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Veuillez remplir ce champ")]
    private ?string $prenomAdmin = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Veuillez remplir ce champ")]
    private ?string $passwordAdmin = null;

    #[ORM\Column]
    #[Assert\Positive]
    #[Assert\Length(min:8,max:8)]
    #[Assert\NotBlank(message:"Veuillez remplir ce champ")]
    private ?int $telAdmin = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Veuillez insérer une image")]
    private ?string $imageAdmin = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmailAdmin(): ?string
    {
        return $this->emailAdmin;
    }

    public function setEmailAdmin(string $emailAdmin): self
    {
        $this->emailAdmin = $emailAdmin;

        return $this;
    }

    public function getNomAdmin(): ?string
    {
        return $this->nomAdmin;
    }

    public function setNomAdmin(string $nomAdmin): self
    {
        $this->nomAdmin = $nomAdmin;

        return $this;
    }

    public function getPrenomAdmin(): ?string
    {
        return $this->prenomAdmin;
    }

    public function setPrenomAdmin(string $prenomAdmin): self
    {
        $this->prenomAdmin = $prenomAdmin;

        return $this;
    }

    public function getPasswordAdmin(): ?string
    {
        return $this->passwordAdmin;
    }

    public function setPasswordAdmin(string $passwordAdmin): self
    {
        $this->passwordAdmin = $passwordAdmin;

        return $this;
    }

    public function getTelAdmin(): ?int
    {
        return $this->telAdmin;
    }

    public function setTelAdmin(int $telAdmin): self
    {
        $this->telAdmin = $telAdmin;

        return $this;
    }

    public function getImageAdmin(): ?string
    {
        return $this->imageAdmin;
    }

    public function setImageAdmin(string $imageAdmin): self
    {
        $this->imageAdmin = $imageAdmin;

        return $this;
    }
}
