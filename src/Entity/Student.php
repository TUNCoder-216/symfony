<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Length;
use App\Repository\StudentRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: StudentRepository::class)]
class Student
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("students")]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    #[Assert\NotBlank(message: "Votre nom  contient   caractères.")]
    #[Groups("students")]
    private ?string $name = null;

    #[ORM\Column]
    #[Assert\Email(message: 'The email {{ value }} is not a valid email.',)]
    #[Groups("students")]
    private ?int $moyenne = null;

    #[ORM\ManyToOne(inversedBy: 'students')]
    private ?Classroom $idclass = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getMoyenne(): ?int
    {
        return $this->moyenne;
    }

    public function setMoyenne(int $moyenne): static
    {
        $this->moyenne = $moyenne;

        return $this;
    }

    public function getIdclass(): ?Classroom
    {
        return $this->idclass;
    }

    public function setIdclass(?Classroom $idclass): static
    {
        $this->idclass = $idclass;

        return $this;
    }
    public function __toString()
    {
        return $this->getId();
    }
}