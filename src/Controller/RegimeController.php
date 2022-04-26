<?php

namespace App\Controller;

use App\Entity\Plat;
use App\Entity\Regime;
use App\Form\RegimeType;
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
     * @Route("/", name="app_regime_index", methods={"GET", "POST"})
     */
    public function index(EntityManagerInterface $entityManager,Request $request, RegimeRepository $rr, PaginatorInterface $paginator): Response
    {
    /*    $regimes = $entityManager
            ->getRepository(Regime::class)
            ->findAll();

        return $this->render('regime/index.html.twig', [
            'regimes' => $regimes,
        ]);*/
        $propertySearch = new Regime();
        $form = $this->createForm(SearchRegimeType::class,$propertySearch);
        $form->handleRequest($request);
        $regimes = $entityManager
            ->getRepository(Regime::class)
            ->findAll();

        if($form->isSubmitted() && $form->isValid()) {
            //on récupère le nom d'article tapé dans le formulaire
            $nregimes = $propertySearch->getTitre();
            if ($nregimes!="")
                //si on a fourni un nom d'article on affiche tous les articles ayant ce nom
                $regimes= $rr->findBy(['titre' => $regimes] );
            else
                //si si aucun nom n'est fourni on affiche tous les articles
                $regimes= $rr->findAll();
        }
        $pl = $paginator->paginate(
            $regimes, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            5// Nombre de résultats par page
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

            return $this->redirectToRoute('app_regime_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('regime/new.html.twig', [
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
