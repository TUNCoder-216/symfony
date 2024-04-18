<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Student
 *
 * @ORM\Table(name="student", indexes={@ORM\Index(name="IDX_B723AF3340D5431D", columns={"idclass_id"})})
 * @ORM\Entity
 */
class Student
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=150, nullable=false)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="moyenne", type="integer", nullable=false)
     */
    private $moyenne;

    /**
     * @var \Classroom
     *
     * @ORM\ManyToOne(targetEntity="Classroom")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idclass_id", referencedColumnName="id")
     * })
     */
    private $idclass;

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


}
