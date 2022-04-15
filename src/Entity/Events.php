<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Events
 *
 * @ORM\Table(name="events")
 * @ORM\Entity
 */
class Events
{
    /**
     * @var int
     *
     * @ORM\Column(name="idEven", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $ideven;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateEven", type="date", nullable=false)
     */
    private $dateeven;

    /**
     * @var string
     *
     * @ORM\Column(name="descri", type="string", length=255, nullable=false)
     */
    private $descri;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    private $nom;

    /**
     * @var int
     *
     * @ORM\Column(name="prix", type="integer", nullable=false)
     */
    private $prix;

    public function getIdeven(): ?int
    {
        return $this->ideven;
    }

    public function getDateeven(): ?\DateTimeInterface
    {
        return $this->dateeven;
    }

    public function setDateeven(\DateTimeInterface $dateeven): self
    {
        $this->dateeven = $dateeven;

        return $this;
    }

    public function getDescri(): ?string
    {
        return $this->descri;
    }

    public function setDescri(string $descri): self
    {
        $this->descri = $descri;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }


}
