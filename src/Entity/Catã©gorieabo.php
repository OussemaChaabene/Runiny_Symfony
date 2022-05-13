<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Catã©gorieabo
 *
 * @ORM\Table(name="catÃ©gorieabo", indexes={@ORM\Index(name="id_user", columns={"id_user"}), @ORM\Index(name="ab_id", columns={"ab_id"})})
 * @ORM\Entity
 */
class Catã©gorieabo
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_categ", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCateg;

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
     * @var \Abonnement
     *
     * @ORM\ManyToOne(targetEntity="Abonnement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ab_id", referencedColumnName="ab_id")
     * })
     */
    private $ab;

    public function getIdCateg(): ?int
    {
        return $this->idCateg;
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

    public function getAb(): ?Abonnement
    {
        return $this->ab;
    }

    public function setAb(?Abonnement $ab): self
    {
        $this->ab = $ab;

        return $this;
    }


}
