<?php

namespace App\Controller;

use App\Entity\Plat;
use App\Repository\PlatRepository;
use Knp\Component\Pager\PaginatorInterface;
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
    public function index(Request $request,PlatRepository $pr, PaginatorInterface $paginator): Response
    {
        $donnees=$pr->findAll();
        $plats = $paginator->paginate(
            $donnees, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            5// Nombre de résultats par page
        );

        return $this->render('plat/index.html.twig', [
            'plats' => $plats,
        ]);
    }

    /**
     * @Route("/plat/{id}", name="showPlat")
     */
    public function showPlat(PlatRepository $pr,$id): Response
    {
        return $this->render('plat/show.html.twig', [
            'plat' => $pr->findOneBy(array('id'=>$id)),
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
