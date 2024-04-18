<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reservation
 *
 * @ORM\Table(name="reservation", indexes={@ORM\Index(name="id_user", columns={"id_user"}), @ORM\Index(name="fk_event_id", columns={"event_id"})})
 * @ORM\Entity
 */
class Reservation
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
     * @var string|null
     *
     * @ORM\Column(name="nomParticipant", type="string", length=255, nullable=true)
     */
    private $nomparticipant;

    /**
     * @var string|null
     *
     * @ORM\Column(name="prenomParticipant", type="string", length=255, nullable=true)
     */
    private $prenomparticipant;

    /**
     * @var string|null
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var int|null
     *
     * @ORM\Column(name="numTel", type="integer", nullable=true)
     */
    private $numtel;

    /**
     * @var string|null
     *
     * @ORM\Column(name="typeDeParticipant", type="string", length=255, nullable=true)
     */
    private $typedeparticipant;

    /**
     * @var int|null
     *
     * @ORM\Column(name="event_id", type="integer", nullable=true)
     */
    private $eventId;

    /**
     * @var int|null
     *
     * @ORM\Column(name="id_user", type="integer", nullable=true)
     */
    private $idUser;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomparticipant(): ?string
    {
        return $this->nomparticipant;
    }

    public function setNomparticipant(?string $nomparticipant): static
    {
        $this->nomparticipant = $nomparticipant;

        return $this;
    }

    public function getPrenomparticipant(): ?string
    {
        return $this->prenomparticipant;
    }

    public function setPrenomparticipant(?string $prenomparticipant): static
    {
        $this->prenomparticipant = $prenomparticipant;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getNumtel(): ?int
    {
        return $this->numtel;
    }

    public function setNumtel(?int $numtel): static
    {
        $this->numtel = $numtel;

        return $this;
    }

    public function getTypedeparticipant(): ?string
    {
        return $this->typedeparticipant;
    }

    public function setTypedeparticipant(?string $typedeparticipant): static
    {
        $this->typedeparticipant = $typedeparticipant;

        return $this;
    }

    public function getEventId(): ?int
    {
        return $this->eventId;
    }

    public function setEventId(?int $eventId): static
    {
        $this->eventId = $eventId;

        return $this;
    }

    public function getIdUser(): ?int
    {
        return $this->idUser;
    }

    public function setIdUser(?int $idUser): static
    {
        $this->idUser = $idUser;

        return $this;
    }


}
