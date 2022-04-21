<?php

namespace App\Controller;

use App\Entity\CaracSport;
use App\Entity\Plat;
use App\Form\CaracType;
use App\Form\PlatType;
use App\Repository\CaracSportRepository;
use App\Repository\PlatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CaracController extends AbstractController
{
    /**
     * @Route("/carac", name="app_carac")
     */
    public function index(CaracSportRepository $csr): Response
    {
        return $this->render('carac/index.html.twig', [
            'caracs' => $csr->findAll(),
        ]);
    }

    /**
     * @Route("/addCarac", name="addCarac")
     */
    public function addCarac(Request $request): Response
    {
        $carac = new CaracSport();

        $form = $this->createForm(CaracType::class,$carac);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($carac);
            $em->flush();

            return $this->redirectToRoute('app_carac');
        }
        return $this->render('carac/createCarac.html.twig',['f'=>$form->createView()]);

    }


}
