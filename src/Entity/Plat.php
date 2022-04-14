<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    private $nom;

    /**
     * @var int
     *
     * @ORM\Column(name="poids", type="integer", nullable=false)
     */
    private $poids;

    /**
     * @var int
     *
     * @ORM\Column(name="sodium", type="integer", nullable=false)
     */
    private $sodium;

    /**
     * @var int
     *
     * @ORM\Column(name="cholesterol", type="integer", nullable=false)
     */
    private $cholesterol;

    /**
     * @var int
     *
     * @ORM\Column(name="carbohydrate", type="integer", nullable=false)
     */
    private $carbohydrate;

    /**
     * @var int
     *
     * @ORM\Column(name="protein", type="integer", nullable=false)
     */
    private $protein;

    /**
     * @var int
     *
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

}
