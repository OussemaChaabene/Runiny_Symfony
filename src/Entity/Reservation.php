<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Date;

/**
 * Reservation
 *
 * @ORM\Table(name="reservation", indexes={@ORM\Index(name="id_user", columns={"id_user"}), @ORM\Index(name="id_salle", columns={"id_salle"}), @ORM\Index(name="id_even", columns={"id_even"})})
 * @ORM\Entity
 */
class Reservation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_reser", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idReser;

    /**
     * @var int
     *
     * @ORM\Column(name="id_coach", type="integer", nullable=false)
     */
    private $idCoach;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", length=255, nullable=false)
     */
    private $date;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id_user")
     * })
     */
    private $idUser;

    /**
     * @var \Evenement
     *
     * @ORM\ManyToOne(targetEntity="Evenement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_even", referencedColumnName="id_even")
     * })
     */
    private $idEven;

    /**
     * @var \Salle
     *
     * @ORM\ManyToOne(targetEntity="Salle")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_salle", referencedColumnName="id_salle")
     * })
     */
    private $idSalle;

    public function getIdReser(): ?int
    {
        return $this->idReser;
    }

    public function getIdCoach(): ?User
    {
        return $this->idUser;
    }

    public function setIdCoach(?User $idCoach): self
    {
        $this->idCoach = $idCoach;

        return $this;
    }

    public function getDate(): ?DateTime
    {
        return $this->date;
    }

    public function setDate(DateTime $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getIdUser(): ?User
    {
        return $this->idUser;
    }

    public function setIdUser(?User $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function getIdEven(): ?Evenement
    {
        return $this->idEven;
    }

    public function setIdEven(?Evenement $idEven): self
    {
        $this->idEven = $idEven;

        return $this;
    }

    public function getIdSalle(): ?Salle
    {
        return $this->idSalle;
    }

    public function setIdSalle(?Salle $idSalle): self
    {
        $this->idSalle = $idSalle;

        return $this;
    }




}
