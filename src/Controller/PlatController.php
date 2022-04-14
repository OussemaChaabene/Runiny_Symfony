<?php

namespace App\Controller;

use App\Entity\Plat;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\PlatType;
use Symfony\Component\HttpFoundation\Request;
class PlatController extends AbstractController
{
    /**
     * @Route("/plat", name="app_plat")
     */
    public function index(): Response
    {
        return $this->render('plat/index.html.twig', [
            'controller_name' => 'PlatController',
        ]);
    }
    /**
     * @Route("/addPlat", name="addPlat")
     */
    public function addPlat(Request $request): Response
    {
        $plat = new Plat();

        $form = $this->createForm(PlatType::class,$plat);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($plat);
            $em->flush();

            return $this->redirectToRoute('app_plat');
        }
        return $this->render('plat/createPlat.html.twig',['f'=>$form->createView()]);

    }

}
