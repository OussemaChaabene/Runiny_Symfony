<?php

namespace App\Controller;

use App\Entity\Plat;
use App\Entity\Search;
use App\Form\SearchformType;
use App\Form\SearchPatType;
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
        $propertySearch = new Search();
        $form = $this->createForm(SearchformType::class,$propertySearch);
        $form->handleRequest($request);

        $plats= $pr->findAll();
        if($form->isSubmitted() && $form->isValid()) {
            $nom = $propertySearch->getNom();
            if ($nom!="")
                $plats= $pr->findBy(['nom' => $nom] );
            else
                $plats= $pr->findAll();
        }
        $pl = $paginator->paginate(
            $plats,
            $request->query->getInt('page', 1),
            5
        );
        return  $this->render('plat/index.html.twig',[ 'form' =>$form->createView(), 'plats' => $pl]);
    }


    /**
     * @Route("/plat/f", name="app_plat_f")
     */
    public function indexf(Request $request,PlatRepository $pr, PaginatorInterface $paginator): Response
    {
        $propertySearch = new Search();
        $form = $this->createForm(SearchformType::class,$propertySearch);
        $form->handleRequest($request);

        $plats= $pr->findAll();
        if($form->isSubmitted() && $form->isValid()) {
            $nom = $propertySearch->getNom();
            if ($nom!="")
                $plats= $pr->findBy(['nom' => $nom] );
            else
                $plats= $pr->findAll();
        }
        $pl = $paginator->paginate(
            $plats,
            $request->query->getInt('page', 1),
            5
        );
        return  $this->render('plat/indexf.html.twig',[ 'form' =>$form->createView(), 'plats' => $pl]);
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
