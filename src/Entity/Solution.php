<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Solution
 *
 * @ORM\Table(name="solution")
 * @ORM\Entity
 */
class Solution
{
    /**
     * @var int
     *
     * @ORM\Column(name="idsolution", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idsolution;

    /**
     * @var string
     *
     * @ORM\Column(name="contenusolution", type="string", length=5000, nullable=false)
     */
    private $contenusolution;

    /**
     * @var string
     *
     * @ORM\Column(name="nomadmin", type="string", length=5000, nullable=false)
     */
    private $nomadmin;

    /**
     * @var int
     *
     * @ORM\Column(name="idreclamation", type="integer", nullable=false)
     */
    private $idreclamation;

    public function getIdsolution(): ?int
    {
        return $this->idsolution;
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

    public function getIdreclamation(): ?int
    {
        return $this->idreclamation;
    }

    public function setIdreclamation(int $idreclamation): static
    {
        $this->idreclamation = $idreclamation;

        return $this;
    }


}
