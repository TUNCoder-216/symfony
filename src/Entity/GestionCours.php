<?php

namespace App\Entity;

use App\Repository\GestionCoursRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GestionCoursRepository::class)]
class GestionCours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Bibliotheque::class)]
    #[ORM\JoinColumn(name: "numero_biblio", referencedColumnName: "id")]
    private ?Bibliotheque $numero_biblio = null;
    

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pdf = null;    


    #[ORM\Column]
    private ?int $nombre_pages = null;

   /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $video;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroBiblio(): ?Bibliotheque  // Adjust return type to GestionCours
    {
        return $this->numero_biblio;
    }

    public function setNumeroBiblio(?Bibliotheque $numero_biblio): static  // Adjust argument type to nullable GestionCours
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

    public function getNombrePages(): ?int
    {
        return $this->nombre_pages;
    }

    public function setNombrePages(int $nombre_pages): static
    {
        $this->nombre_pages = $nombre_pages;

        return $this;
    }

    public function getVideo(): ?string
    {
        return $this->video;
    }

    public function setVideo(?string $video): static
    {
        $this->video = $video;

        return $this;
    }
        /**
     * Returns the string representation of the object.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->numero_biblio ?? 'Untitled GestionCours'; // Return the titre property or a default string if it's null
    }
    

}
