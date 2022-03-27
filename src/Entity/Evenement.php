<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Evenement
 *
 * @ORM\Table(name="evenement", indexes={@ORM\Index(name="id_salle", columns={"id_salle"})})
 * @ORM\Entity
 */
class Evenement
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_even", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idEven;

    /**
     * @var string
     *
     * @ORM\Column(name="descri", type="string", length=255, nullable=false)
     */
    private $descri;

    /**
     * @var string
     *
     * @ORM\Column(name="Date", type="string", length=255, nullable=false)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_even", type="string", length=255, nullable=false)
     */
    private $nomEven;

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
