<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

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
     * @Groups("post:read")
     * @ORM\Column(name="id_seance", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idSeance;

    /**
     * @Groups("post:read")
     * @var \DateTime
     * #[Assert\GreaterThan('now')]
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */

    private $date;

    /**
     * @var string
     * @Groups("post:read")
     * @ORM\Column(name="type_seance", type="string", length=255, nullable=false)
     */
    private $typeSeance;

    public function getIdSeance(): ?int
    {
        return $this->idSeance;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getTypeSeance(): ?string
    {
        return $this->typeSeance;
    }

    public function setTypeSeance(string $typeSeance): self
    {
        $this->typeSeance = $typeSeance;

        return $this;
    }
    public function __construct()
    {
        $this->date = new \DateTime('now');
    }

}
