<?php

namespace App\Controller;

use App\Entity\Payement;
use App\Entity\Plat;
use App\Form\PlatType;
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
    public function statistiques(PayementRepository $pr){

        $payements = $pr->sommeByDate();

        $dates = [];
        $paySum = [];

        foreach($payements as $payement){
            $dates[] = $payement['date'];
            $paySum[] = (int)$payement['sum'];
        }

        return $this->render('payement/historique.html.twig', [
            'annee' => json_encode($dates),
            'paySums' => json_encode($paySum),
            'x' =>$dates ,
            'y' =>$paySum ,
        ]);
    }

}
