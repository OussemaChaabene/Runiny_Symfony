<?php

namespace App\Controller;

use App\Entity\Categorieabo;
use App\Form\CategorieaboType;
use App\Repository\CategorieaboRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * @Route("/abonnement")
 */
class CategorieaboController extends AbstractController
{
    /**
     * @Route("/", name="app_categorieabo_index", methods={"GET"})
     */
    public function index(CategorieaboRepository $categorieaboRepository): Response
    {
        return $this->render('categorieabo/index.html.twig', [
            'categorieabos' => $categorieaboRepository->findAll(),
        ]);
    }
    /**
     * @Route("/back", name="back", methods={"GET"})
     */
    public function indexback(CategorieaboRepository $categorieaboRepository): Response
    {
        return $this->render('categorieabo/abBack.html.twig', [
            'categorieabos' => $categorieaboRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_categorieabo_new", methods={"GET", "POST"})
     */
    public function new(Request $request, CategorieaboRepository $categorieaboRepository): Response
    {
        $categorieabo = new Categorieabo();
        $form = $this->createForm(CategorieaboType::class, $categorieabo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categorieaboRepository->add($categorieabo);
            return $this->redirectToRoute('app_categorieabo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('categorieabo/new.html.twig', [
            'categorieabo' => $categorieabo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_categorieabo_show", methods={"GET"})
     */
   public function show(Categorieabo $categorieabo): Response
    {
        return $this->render('categorieabo/show.html.twig', [
            'categorieabo' => $categorieabo,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_categorieabo_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Categorieabo $categorieabo, CategorieaboRepository $categorieaboRepository): Response
    {
        $form = $this->createForm(CategorieaboType::class, $categorieabo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categorieaboRepository->add($categorieabo);
            return $this->redirectToRoute('app_categorieabo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('categorieabo/edit.html.twig', [
            'categorieabo' => $categorieabo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_categorieabo_delete", methods={"POST"})
     */
    public function delete(Request $request, Categorieabo $categorieabo, CategorieaboRepository $categorieaboRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categorieabo->getId(), $request->request->get('_token'))) {
            $categorieaboRepository->remove($categorieabo);
        }

        return $this->redirectToRoute('back', [], Response::HTTP_SEE_OTHER);
    }
   /* /**
     * @Route("/lili", name="x",methods={"GET"})
     */
    /*public function indexMobile(EntityManagerInterface $entityManager,NormalizerInterface $normalizer,CategorieaboRepository  $ar): Response
    {

        $Abonnements = $ar ->findAll();
        $abonnement = $normalizer ->normalize($Abonnements,'json',['groups'=>'post:read']);

        return new Response(json_encode($abonnement));
    }*/
}
