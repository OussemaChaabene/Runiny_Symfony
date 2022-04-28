<?php

namespace App\Controller;

use App\Entity\Payement;
use App\Entity\Plat;
use App\Form\PlatType;
use App\Repository\CaracSportRepository;
use App\Repository\PayementRepository;
use App\Repository\PlatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PayController extends AbstractController
{
    /**
     * @Route("/pay", name="app_pay")
     */
    public function index(): Response
    {
        return $this->render('pay/index.html.twig', [
            'controller_name' => 'PayController',
        ]);
    }

    /**
     * @Route("/stats", name="stats")
     */
    public function statistiques(PayementRepository $pr,CaracSportRepository $cr){

        $payements = $pr->sommeByDate();
        $total = $pr->somme();
        $nb = $cr->nombreUsers();
        $nbp=$pr->nbp();

        $dates = [];
        $paySum = [];

        foreach($payements as $payement){
            $dates[] = $payement['date'];
            $paySum[] = (int)$payement['sum'];
        }

        return $this->render('payement/historique.html.twig', [
            'annee' => json_encode($dates),
            'paySums' => json_encode($paySum),
            'total' =>$total,
            'nb' =>$nb ,
            'nbp' =>$nbp ,
        ]);
    }

}
