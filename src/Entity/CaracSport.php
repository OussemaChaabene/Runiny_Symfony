<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;

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
     *
     * @Groups("post:read")
     */
    private $id;

    /**
     * @var int
     *
     * @Groups("post:read")
     * @ORM\Column(name="taille", type="integer", nullable=false)
     */
    private $taille;

    /**
     * @var int
     *
     * @Groups("post:read")
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
     *
     * @Groups("post:read")
     */
    private $protNeeds;

    /**
     * @ORM\Column(type="integer", nullable=true)
     *
     * @Groups("post:read")
     */
    private $calorieNeed;

    /**
     * @ORM\Column(type="integer", nullable=true)
     *
     * @Groups("post:read")
     */
    private $age;


    protected $captchaCode;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Groups("post:read")
     */
    private $genre;

    public function getCaptchaCode()
    {
        return $this->captchaCode;
    }

    public function setCaptchaCode($captchaCode)
    {
        $this->captchaCode = $captchaCode;
    }
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

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }


}
