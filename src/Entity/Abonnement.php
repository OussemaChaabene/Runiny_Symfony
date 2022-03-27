<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Abonnement
 *
 * @ORM\Table(name="abonnement", indexes={@ORM\Index(name="id_salle", columns={"id_salle"})})
 * @ORM\Entity
 */
class Abonnement
{
    /**
     * @var int
     *
     * @ORM\Column(name="ab_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $abId;

    /**
     * @var string
     *
     * @ORM\Column(name="ab_nom", type="string", length=255, nullable=false)
     */
    private $abNom;

    /**
     * @var string
     *
     * @ORM\Column(name="ab_type", type="string", length=255, nullable=false)
     */
    private $abType;

    /**
     * @var int
     *
     * @ORM\Column(name="ab_prix", type="integer", nullable=false)
     */
    private $abPrix;

    /**
     * @var \Salle
     *
     * @ORM\ManyToOne(targetEntity="Salle")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_salle", referencedColumnName="id_salle")
     * })
     */
    private $idSalle;


}
