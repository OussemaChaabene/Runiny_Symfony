<?php

namespace App\Controller;

use App\Entity\Plat;
use App\Entity\Regime;
use App\Entity\Search;
use App\Form\RegimeType;
use App\Form\SearchformType;
use App\Form\SearchPatType;
use App\Form\SearchRegimeType;
use App\Repository\RegimeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/regime")
 */
class RegimeController extends AbstractController
{
    /**
     * @Route("/f", name="app_regime_index", methods={"GET", "POST"})
     */
    public function index(Request $request, RegimeRepository $rr, PaginatorInterface $paginator): Response
    {
        $propertySearch = new Search();
        $form = $this->createForm(SearchformType::class,$propertySearch);
        $form->handleRequest($request);

        $regime= $rr->findAll();
        if($form->isSubmitted() && $form->isValid()) {
            $nom = $propertySearch->getNom();
            if ($nom!="")
                $regime= $rr->findBy(['titre' => $nom] );
            else
                $regime= $rr->findAll();
        }
        $pl = $paginator->paginate(
            $regime,
            $request->query->getInt('page', 1),
            5
        );
        return  $this->render('regime/indexf.html.twig',[ 'form' =>$form->createView(), 'regimes' => $pl]);
    }
    /**
     * @Route("/", name="app_regime_index_b", methods={"GET", "POST"})
     */
    public function indexb(Request $request, RegimeRepository $rr, PaginatorInterface $paginator): Response
    {
        $propertySearch = new Search();
        $form = $this->createForm(SearchformType::class,$propertySearch);
        $form->handleRequest($request);

        $regime= $rr->findAll();
        if($form->isSubmitted() && $form->isValid()) {
            $nom = $propertySearch->getNom();
            if ($nom!="")
                $regime= $rr->findBy(['titre' => $nom] );
            else
                $regime= $rr->findAll();
        }
        $pl = $paginator->paginate(
            $regime,
            $request->query->getInt('page', 1),
            5
        );
        return  $this->render('regime/index.html.twig',[ 'form' =>$form->createView(), 'regimes' => $pl]);
    }
    /**
     * @Route("/new", name="app_regime_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $regime = new Regime();
        $form = $this->createForm(RegimeType::class, $regime);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($regime);
            $entityManager->flush();

            return $this->redirectToRoute('app_regime_index_b', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('regime/new.html.twig', [
            'regime' => $regime,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/new", name="app_regime_new_f", methods={"GET", "POST"})
     */
    public function newf(Request $request, EntityManagerInterface $entityManager): Response
    {
        $regime = new Regime();
        $form = $this->createForm(RegimeType::class, $regime);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($regime);
            $entityManager->flush();

            return $this->redirectToRoute('app_regime_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('regime/newf.html.twig', [
            'regime' => $regime,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_regime_show", methods={"GET"})
     */
    public function show(Regime $regime): Response
    {


        return $this->render('regime/show.html.twig', [
            'regime' => $regime,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_regime_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Regime $regime, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RegimeType::class, $regime);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_regime_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('regime/edit.html.twig', [
            'regime' => $regime,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_regime_delete", methods={"POST"})
     */
    public function delete(Request $request, Regime $regime, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$regime->getId(), $request->request->get('_token'))) {
            $entityManager->remove($regime);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_regime_index', [], Response::HTTP_SEE_OTHER);
    }
}
