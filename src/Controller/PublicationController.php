<?php

namespace App\Controller;

use App\Entity\Publication;
use App\Form\PublicationType;
use App\Repository\PublicationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PublicationController extends AbstractController
{
    /**
     * @Route("/publications", name="app_publication")
     */
    public function index(PublicationRepository $pr): Response
    {
        return $this->render('publication/index.html.twig', [
            'publications' => $pr->findAll(),
        ]);
    }

    /**
     * @Route("/pub/addPub", name="addPub")
     */
    public function addPub(Request $request): Response
    {
        $pub = new Publication();

        $form = $this->createForm(PublicationType::class,$pub);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pub);
            $em->flush();

            return $this->redirectToRoute('app_publication');
        }
        return $this->render('Publication/createPub.html.twig',['f'=>$form->createView()]);

    }
    /**
     * @Route("/pub/pubDelete/{id}", name="deletePub")
     */
    public function deletePub(Publication $pub): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($pub);
        $em->flush();

        return $this->redirectToRoute('app_publication');


    }
    /**
     * @Route("/pub/editPub/{id}", name="editPub")
     */
    public function editPub(Publication $pub, Request $request)
    {
       // $this->denyAccessUnlessGranted('pub_edit', $pub);
        $form = $this->createForm(PublicationType::class, $pub);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($pub);
            $em->flush();

            return $this->redirectToRoute('app_publication');
        }

        return $this->render('Publication/createPub.html.twig', [
            'f' => $form->createView(),
            'pub' => $pub
        ]);
    }
}
