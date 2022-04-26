<?php

namespace App\Controller;

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
}
