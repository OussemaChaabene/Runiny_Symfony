<?php

namespace App\Controller;

use App\Repository\PayementRepository;
use App\Repository\PlatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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


        // On va chercher le nombre d'annonces publiées par date
        $payements = $pr->sommeByDate();

        $dates = [];
        $paySum = [];

        // On "démonte" les données pour les séparer tel qu'attendu par ChartJS
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
