<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Events
 *
 * @ORM\Table(name="events")
 * @ORM\Entity
 */
class Events
{
    /**
     * @var int
     *
     * @ORM\Column(name="idEven", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $ideven;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateEven", type="date", nullable=false)
     */
    private $dateeven;

    /**
     * @var string
     *
     * @ORM\Column(name="descri", type="string", length=255, nullable=false)
     */
    private $descri;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    private $nom;

    /**
     * @var int
     *
     * @ORM\Column(name="prix", type="integer", nullable=false)
     */
    private $prix;


}
