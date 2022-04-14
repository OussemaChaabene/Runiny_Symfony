<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PlanningClient
 *
 * @ORM\Table(name="planning_client", indexes={@ORM\Index(name="id_user", columns={"id_user"}), @ORM\Index(name="id_seance", columns={"id_seance"})})
 * @ORM\Entity
 */
class PlanningClient
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_p", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idP;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id_user")
     * })
     */
    private $idUser;

    /**
     * @var \Seance
     *
     * @ORM\ManyToOne(targetEntity="Seance")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_seance", referencedColumnName="id_seance")
     * })
     */
    private $idSeance;


}
