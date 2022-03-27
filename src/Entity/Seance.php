<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Seance
 *
 * @ORM\Table(name="seance")
 * @ORM\Entity
 */
class Seance
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_seance", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idSeance;

    /**
     * @var int
     *
     * @ORM\Column(name="date", type="integer", nullable=false)
     */
    private $date;

    /**
     * @var int
     *
     * @ORM\Column(name="heur", type="integer", nullable=false)
     */
    private $heur;

    /**
     * @var int
     *
     * @ORM\Column(name="type_seance", type="integer", nullable=false)
     */
    private $typeSeance;


}
