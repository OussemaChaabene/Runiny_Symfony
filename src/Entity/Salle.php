<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
/**
 * Salle
 *
 * @ORM\Table(name="salle")
 * @ORM\Entity
 */
class Salle
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_salle", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups("post:read")
     */
    private $idSalle;

    /**
     * @var string
     *
     * @ORM\Column(name="adress_salle", type="string", length=255, nullable=false)
     */
    private $adressSalle;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    private $nom;

    /**
     * @var int
     *@Groups("post:read")
     * @ORM\Column(name="rating", type="integer", nullable=false)
     */
    private $rating;

    public function getIdSalle(): ?int
    {
        return $this->idSalle;
    }

    public function getAdressSalle(): ?string
    {
        return $this->adressSalle;
    }

    public function setAdressSalle(string $adressSalle): self
    {
        $this->adressSalle = $adressSalle;

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

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(int $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function __toString()
    {
        return $this->nom;
    }


}
