<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
/**
 * Plat
 *
 * @ORM\Table(name="plat")
 * @ORM\Entity
 */
class Plat
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups("post:read")
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank(message=" Veuillez saisir un nom")
     *
     * @Groups("post:read")
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    private $nom;

    /**
     * @var int
     * @Assert\NotNull(message=" Veuillez saisir un poids")
     *
     * @Groups("post:read")
     * @ORM\Column(name="poids", type="integer", nullable=false)
     */
    private $poids;

    /**
     * @var int
     * @Assert\NotNull(message=" Veuillez saisir la quantité de sodium")
     *
     * @Groups("post:read")
     * @ORM\Column(name="sodium", type="integer", nullable=false)
     */
    private $sodium;

    /**
     * @var int
     * @Assert\NotNull(message=" Veuillez saisir la quantité de cholesterol")
     *
     * @Groups("post:read")
     * @ORM\Column(name="cholesterol", type="integer", nullable=false)
     */
    private $cholesterol;

    /**
     * @var int
     * @Assert\NotNull(message=" Veuillez saisir la quantité de carbohydrate")
     *
     * @Groups("post:read")
     * @ORM\Column(name="carbohydrate", type="integer", nullable=false)
     */
    private $carbohydrate;

    /**
     * @var int
     * @Assert\NotNull(message=" Veuillez saisir la quantité de protein")
     *
     * @Groups("post:read")
     * @ORM\Column(name="protein", type="integer", nullable=false)
     */
    private $protein;

    /**
     * @var int
     * @Assert\NotNull(message=" Veuillez saisir les calories ")
     *
     * @Groups("post:read")
     * @ORM\Column(name="calories", type="integer", nullable=false)
     */
    private $calories;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Regime", mappedBy="plat")
     */
    private $regime;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->regime = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPoids(): ?int
    {
        return $this->poids;
    }

    public function setPoids(int $poids): self
    {
        $this->poids = $poids;

        return $this;
    }

    public function getSodium(): ?int
    {
        return $this->sodium;
    }

    public function setSodium(int $sodium): self
    {
        $this->sodium = $sodium;

        return $this;
    }

    public function getCholesterol(): ?int
    {
        return $this->cholesterol;
    }

    public function setCholesterol(int $cholesterol): self
    {
        $this->cholesterol = $cholesterol;

        return $this;
    }

    public function getCarbohydrate(): ?int
    {
        return $this->carbohydrate;
    }

    public function setCarbohydrate(int $carbohydrate): self
    {
        $this->carbohydrate = $carbohydrate;

        return $this;
    }

    public function getProtein(): ?int
    {
        return $this->protein;
    }

    public function setProtein(int $protein): self
    {
        $this->protein = $protein;

        return $this;
    }

    public function getCalories(): ?int
    {
        return $this->calories;
    }

    public function setCalories(int $calories): self
    {
        $this->calories = $calories;

        return $this;
    }

    /**
     * @return Collection<int, Regime>
     */
    public function getRegime(): Collection
    {
        return $this->regime;
    }

    public function addRegime(Regime $regime): self
    {
        if (!$this->regime->contains($regime)) {
            $this->regime[] = $regime;
            $regime->addPlat($this);
        }

        return $this;
    }

    public function removeRegime(Regime $regime): self
    {
        if ($this->regime->removeElement($regime)) {
            $regime->removePlat($this);
        }

        return $this;
    }

}
