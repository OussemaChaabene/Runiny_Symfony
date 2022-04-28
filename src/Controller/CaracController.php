<?php

namespace App\Controller;

use App\Entity\CaracSport;
use App\Entity\Plat;
use App\Form\CaracType;
use App\Form\PlatType;
use App\metier\caracMetier;
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
        return $this->render('carac/showAll.html.twig', [
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

            $cm = new caracMetier();

            $em->persist($cm->calculCarac($carac));
            $em->flush();

            return $this->redirectToRoute('app_carac');
        }
        return $this->render('carac/createCarac.html.twig',['f'=>$form->createView()]);

    }

    /**
     * @Route("/carac/f/{id}", name="c_show_f", methods={"GET"})
     */
    public function showcf(CaracSportRepository $csr,$id): Response
    {
        return $this->render('carac/indexf.html.twig', [
            'carac' => $csr->findOneBy(array('id'=>$id)),
        ]);
    }

    /**
     * @Route("/carac/{id}", name="c_show", methods={"GET"})
     */
    public function showc(CaracSportRepository $csr,$id): Response
    {
        return $this->render('carac/index.html.twig', [
            'carac' => $csr->findOneBy(array('id'=>$id)),
        ]);
    }

    /**
     * @Route("/suppCarac/{id}", name="suppCarac")
     */
    public function supprimerCarac(CaracSport  $c): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($c);
        $em->flush();

        return $this->redirectToRoute('app_carac');
    }

    /**
     * @Route("/modifCarac/{id}", name="modifCarac")
     */
    public function modifierCarac($id,Request $request): Response
    {
        $carac = $this->getDoctrine()->getManager()->getRepository(CaracSport::class)->find($id);

        $form = $this->createForm(CaracType::class,$carac);

        $form->handleRequest($request);

        $cm = new caracMetier();
        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush($cm->calculCarac($carac));

            return $this->redirectToRoute('app_carac');
        }
        return $this->render('carac/updateCarac.html.twig',['f'=>$form->createView()]);

    }
}
