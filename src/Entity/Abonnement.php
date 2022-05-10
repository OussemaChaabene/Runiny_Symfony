<?php

namespace App\Entity;

use App\Repository\AbonnementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass=AbonnementRepository::class)
 */
class Abonnement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("post:read")
     */
    private $id;

    /**
     * @Assert\NotBlank(message = "Veuillez ecrire le nom.")
     *
     * @Assert\Regex(
     *     pattern     = "/^[a-z]+$/i",
     *     htmlPattern = "[a-zA-Z]+",
     *     message = "Le nom ne doit contenir que des caractères")
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("post:read")
     */
    private $abNom;

    /**
     * @Assert\NotBlank(message = "Veuillez ecrire le type.")
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("post:read")
     */
    private $abType;

    /**
     * @Assert\NotBlank(message = "Veuillez entrer le prix.")
     * @Assert\Type(type="integer",message = "Prix doit etre un nombre")
     * @Assert\Positive(message = "le prix doit etre positif")
     * @ORM\Column(type="integer")
     * @Groups("post:read")
     */
    private $abPrix;

    /**
     * @ORM\OneToMany(targetEntity=Categorieabo::class, mappedBy="Abonnement")

     */
    private $fkCategorie;

    public function __construct()
    {
        $this->fkCategorie = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAbNom(): ?string
    {
        return $this->abNom;
    }

    public function setAbNom(?string $abNom): self
    {
        $this->abNom = $abNom;

        return $this;
    }

    public function getAbType(): ?string
    {
        return $this->abType;
    }

    public function setAbType(?string $abType): self
    {
        $this->abType = $abType;

        return $this;
    }

    public function getAbPrix(): ?int
    {
        return $this->abPrix;
    }

    public function setAbPrix(int $abPrix): self
    {
        $this->abPrix = $abPrix;

        return $this;
    }

    /**
     * @return Collection<int, categorieabo>
     */
    public function getFkCategorie(): Collection
    {
        return $this->fkCategorie;
    }

    public function addFkCategorie(categorieabo $fkCategorie): self
    {
        if (!$this->fkCategorie->contains($fkCategorie)) {
            $this->fkCategorie[] = $fkCategorie;
            $fkCategorie->setAbonnement($this);
        }

        return $this;
    }

    public function removeFkCategorie(categorieabo $fkCategorie): self
    {
        if ($this->fkCategorie->removeElement($fkCategorie)) {
            if ($fkCategorie->getAbonnement() === $this) {
                $fkCategorie->setAbonnement(null);
            }
        }

        return $this;
    }
    public function __toString(): string
    {
        return $this->abNom;
    }

}
