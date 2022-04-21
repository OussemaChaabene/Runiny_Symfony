<?php

namespace App\Controller;

use App\Entity\Plat;
use App\Repository\PlatRepository;
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
    public function index(PlatRepository $pr): Response
    {
        return $this->render('plat/index.html.twig', [
            'plats' => $pr->findAll(),
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
    /**
     * @Route("/suppPlat/{id}", name="suppPlat")
     */
    public function supprimerPlat(Plat  $p): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($p);
        $em->flush();

        return $this->redirectToRoute('app_plat');
    }

    /**
     * @Route("/modifPlat/{id}", name="modifPlat")
     */
    public function modifierPlat($id,Request $request): Response
    {
        $plat = $this->getDoctrine()->getManager()->getRepository(Plat::class)->find($id);

        $form = $this->createForm(PlatType::class,$plat);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('app_plat');
        }
        return $this->render('plat/updatePlat.html.twig',['f'=>$form->createView()]);

    }

}
