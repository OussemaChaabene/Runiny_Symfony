<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CaracSport
 *
 * @ORM\Table(name="carac_sport", indexes={@ORM\Index(name="fk_carac_user", columns={"user"})})
 * @ORM\Entity
 */
class CaracSport
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
     * @var int
     *
     * @ORM\Column(name="taille", type="integer", nullable=false)
     */
    private $taille;

    /**
     * @var int
     *
     * @ORM\Column(name="poids", type="integer", nullable=false)
     */
    private $poids;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user", referencedColumnName="id_user")
     * })
     */
    private $user;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $protNeeds;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $calorieNeed;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $age;

    public function getProtNeeds(): ?int
    {
        return $this->protNeeds;
    }

    public function setProtNeeds(?int $protNeeds): self
    {
        $this->protNeeds = $protNeeds;

        return $this;
    }

    public function getCalorieNeed(): ?int
    {
        return $this->calorieNeed;
    }

    public function setCalorieNeed(?int $calorieNeed): self
    {
        $this->calorieNeed = $calorieNeed;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(?int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTaille(): ?int
    {
        return $this->taille;
    }

    public function setTaille(int $taille): self
    {
        $this->taille = $taille;

        return $this;
    }

    public function getPoids(): ?int
    {
        return $this->poids;
    }

    public function setPoids(int $poids): self
    {
        $this->poids = $poids;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }


}
