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
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
class PlatController extends AbstractController
{
    /**
     * @Route("/plat/all", name="app_plat")
     */
    public function index(Request $request, PlatRepository $pr, PaginatorInterface $paginator): Response
    {
        $propertySearch = new Search();
        $form = $this->createForm(SearchformType::class, $propertySearch);
        $form->handleRequest($request);

        $plats = $pr->findAll();
        if ($form->isSubmitted() && $form->isValid()) {
            $nom = $propertySearch->getNom();
            if ($nom != "")
                $plats = $pr->findBy(['nom' => $nom]);
            else
                $plats = $pr->findAll();
        }
        $pl = $paginator->paginate(
            $plats,
            $request->query->getInt('page', 1),
            5
        );
        return  $this->render('plat/index.html.twig',[ 'form' =>$form->createView(), 'plats' => $pl]);
    }


    /**
     * @Route("/plat/allf", name="app_plat_f")
     */
    public function indexf(Request $request, PlatRepository $pr, PaginatorInterface $paginator): Response
    {
        $propertySearch = new Search();
        $form = $this->createForm(SearchformType::class, $propertySearch);
        $form->handleRequest($request);

        $plats = $pr->findAll();
        if ($form->isSubmitted() && $form->isValid()) {
            $nom = $propertySearch->getNom();
            if ($nom != "")
                $plats = $pr->findBy(['nom' => $nom]);
            else
                $plats = $pr->findAll();
        }
        $pl = $paginator->paginate(
            $plats,
            $request->query->getInt('page', 1),
            5
        );
        return $this->render('plat/indexf.html.twig', ['form' => $form->createView(), 'plats' => $pl]);
    }

    /**
     * @Route("/plat/{id}", name="showPlat")
     *
     */
    public function showPlat(PlatRepository $pr, $id): Response
    {
        return $this->render('plat/show.html.twig', ['plat' => $pr->findOneBy(array('id'=>$id)),]);

    }

    /**
     * @Route("/addPlat", name="addPlat")
     */
    public function addPlat(Request $request): Response
    {
        $plat = new Plat();

        $form = $this->createForm(PlatType::class, $plat);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
    public function supprimerPlat(Plat $p): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($p);
        $em->flush();

        return $this->redirectToRoute('app_plat');
    }

    /**
     * @Route("/modifPlat/{id}", name="modifPlat")
     */
    public function modifierPlat($id, Request $request): Response
    {
        $plat = $this->getDoctrine()->getManager()->getRepository(Plat::class)->find($id);

        $form = $this->createForm(PlatType::class, $plat);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('app_plat');
        }
        return $this->render('plat/updatePlat.html.twig', ['f' => $form->createView()]);

    }

//-----------------------------JSON------------------------------------

    /**
     * @Route("/j/plat/all", name="app_plat_j")
     */
    public function indexJ(Request $request, PlatRepository $pr, NormalizerInterface $normalizer): Response
    {
        $propertySearch = new Search();
        $form = $this->createForm(SearchformType::class, $propertySearch);
        $form->handleRequest($request);
        $platss = $pr->findAll();
        $jsonContent = $normalizer->normalize($platss, 'json', ['groups' => 'post:read']);


        return new Response(json_encode($jsonContent));
    }


    /**
     * @Route("/j/plat/{id}", name="showPlat_j")
     * @throws ExceptionInterface
     */
    public function showPlatJ(PlatRepository $pr, $id, NormalizerInterface $normalizer): Response
    {
        $plat = $pr->find($id);
        $jsonContent = $normalizer->normalize($plat, 'json', ['groups' => 'post:read']);
        return new Response(json_encode($jsonContent));

    }

    /**
     * @Route("/j/addPlat", name="addPlat")
     */
    public function addPlatJ(Request $request,NormalizerInterface $normalizer): Response
    {
        $plat = new Plat();

        $em = $this->getDoctrine()->getManager();
        $plat->setNom($request->get('nom'));
        $plat->setPoids($request->get('poids'));
        $plat->setSodium($request->get('sod'));
        $plat->setCholesterol($request->get('chol'));
        $plat->setCarbohydrate($request->get('carb'));
        $plat->setCalories($request->get('cal'));
        $plat->setProtein($request->get('prot'));
        $em->persist($plat);
        $em->flush();
        $c = $normalizer->normalize($plat, 'json', ['groups' => 'post:read']);

        return new Response(json_encode($c));
    }

    /**
     * @Route("/j/suppPlat/{id}", name="suppPlat")
     */
    public function supprimerPlatJ(Plat $p, NormalizerInterface $normalizer): Response
    {
        $em = $this->getDoctrine()->getManager();

        $em->remove($p);
        $em->flush();
        $jsonContent = $normalizer->normalize($p, 'json', ['groups' => 'post:read']);

        return new Response("Plat supprimé" . json_encode($jsonContent));
    }

    /**
     * @Route("/j/modifPlat/{id}", name="modifPlat")
     */
    public function modifierPlatJ($id, Request $request,NormalizerInterface $normalizer): Response
    {
        $plat = $this->getDoctrine()->getManager()->getRepository(Plat::class)->find($id);

        $em = $this->getDoctrine()->getManager();
        $plat->setNom($request->get('nom'));
        $plat->setPoids($request->get('poids'));
        $plat->setSodium($request->get('sod'));
        $plat->setCholesterol($request->get('chol'));
        $plat->setCarbohydrate($request->get('carb'));
        $plat->setCalories($request->get('cal'));

        $em->flush();
        $c = $normalizer->normalize($plat, 'json', ['groups' => 'post:read']);

        return new Response("Modifié avec succes".json_encode($c));


    }


}