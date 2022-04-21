<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Seance
 *
 * @ORM\Table(name="seance")
 * @ORM\Entity
 */
class Seance
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_seance", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idSeance;

    /**
     * @var int
     *
     * @ORM\Column(name="date", type="integer", nullable=false)
     */
    private $date;

    /**
     * @var int
     *
     * @ORM\Column(name="heur", type="integer", nullable=false)
     */
    private $heur;

    /**
     * @var int
     *
     * @ORM\Column(name="type_seance", type="integer", nullable=false)
     */
    private $typeSeance;

    public function getIdSeance(): ?int
    {
        return $this->idSeance;
    }

    public function getDate(): ?int
    {
        return $this->date;
    }

    public function setDate(int $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getHeur(): ?int
    {
        return $this->heur;
    }

    public function setHeur(int $heur): self
    {
        $this->heur = $heur;

        return $this;
    }

    public function getTypeSeance(): ?int
    {
        return $this->typeSeance;
    }

    public function setTypeSeance(int $typeSeance): self
    {
        $this->typeSeance = $typeSeance;

        return $this;
    }


}
