<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Repository\CommentaireRepository;
use App\Repository\PublicationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentaireController extends AbstractController
{
    /**
     * @Route("/commentaires/{id}", name="app_commentaire")
     */
    public function index(CommentaireRepository $cr,$id): Response
    {
        return $this->render('commentaire/index.html.twig', [
            'commentaires' => $cr->findAllByIdPub(7),
        ]);
    }
    /**
     * @Route("/com/addcom", name="addcom")
     */
    public function addcom(Request $request,PublicationRepository $pr): Response
    {
        $com = new Commentaire();

        $form = $this->createForm(CommentaireType::class,$com);

        $form->handleRequest($request);

        $pub =$pr->findById(7);
        $com->setPublication($pub[0]);
        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($com);
            $em->flush();

            return $this->redirectToRoute('app_commentaire',6);
        }
        return $this->render('Commentaire/createCom.html.twig',['f'=>$form->createView()]);

    }
    /**
     * @Route("/com/comDelete/{id}", name="deletecom")
     */
    public function deletecom(Commentaire $com): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($com);
        $em->flush();

        return $this->redirectToRoute('app_Commentaire');


    }
    /**
     * @Route("/com/editcom/{id}", name="editcom")
     */
    public function editcom(Commentaire $com, Request $request)
    {
        $form = $this->createForm(CommentaireType::class, $com);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($com);
            $em->flush();

            return $this->redirectToRoute('app_commentaire');
        }

        return $this->render('Commentaire/createCom.html.twig', [
            'f' => $form->createView(),
            'com' => $com
        ]);
    }
}

