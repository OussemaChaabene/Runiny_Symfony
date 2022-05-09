<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Payement
 *
 * @ORM\Table(name="payement", indexes={@ORM\Index(name="ab_id", columns={"ab_id"}), @ORM\Index(name="id_user", columns={"id_user"})})
 * @ORM\Entity
 */
class Payement
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_pay", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPay;

    /**
     * @var int
     *
     * @ORM\Column(name="montant", type="integer", nullable=false)
     */
    private $montant;

    /**
     * @var string
     *
     * @ORM\Column(name="date_pay", type="string", length=255, nullable=false)
     */
    private $datePay;

    /**
     * @var \Abonnement
     *
     * @ORM\ManyToOne(targetEntity="Abonnement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ab_id", referencedColumnName="ab_id")
     * })
     */
    private $ab;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id_user")
     * })
     */
    private $idUser;

    public function getIdPay(): ?int
    {
        return $this->idPay;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(int $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getDatePay(): ?string
    {
        return $this->datePay;
    }

    public function setDatePay(string $datePay): self
    {
        $this->datePay = $datePay;

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

    public function getIdUser(): ?User
    {
        return $this->idUser;
    }

    public function setIdUser(?User $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }


}
