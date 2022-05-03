<?php

namespace App\Controller;

use App\Entity\CaracSport;
use App\Entity\Plat;
use App\Entity\Search;
use App\Form\CaracType;
use App\Form\PlatType;
use App\Form\SearchformType;
use App\metier\caracMetier;
use App\Repository\CaracSportRepository;
use App\Repository\PlatRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class CaracController extends AbstractController
{
    /**
     * @Route("/caracs, name="app_carac")
     */
    public function index(CaracSportRepository $csr,Request $request, PaginatorInterface $paginator): Response
    {
        $propertySearch = new Search();
        $form = $this->createForm(SearchformType::class,$propertySearch);
        $form->handleRequest($request);

        $caracs= $csr->findAll();

        $pl = $paginator->paginate(
            $caracs,
            $request->query->getInt('page', 1),
            5
        );
        return $this->render('carac/showAll.html.twig', [
           'form' =>$form->createView(), 'caracs' => $pl]);
    }

    /**
     * @Route("/addCarac", name="addCarac")
     */
    public function addCarac(Request $request): Response
    {
        $carac = new CaracSport();

        $form = $this->createForm(CaracType::class,$carac);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $cm = new caracMetier();

            $em->persist($cm->calculCarac($carac));
            $em->flush();

            return $this->redirectToRoute('app_carac');
        }
        return $this->render('carac/createCarac.html.twig',['f'=>$form->createView()]);

    }

    /**
     * @Route("/carac/f/{id}", name="c_show_f", methods={"GET"})
     */
    public function showcf(CaracSportRepository $csr,$id): Response
    {
        return $this->render('carac/indexf.html.twig', [
            'carac' => $csr->findOneBy(array('id'=>$id)),
        ]);
    }

    /**
     * @Route("/carac/{id}", name="c_show", methods={"GET"})
     */
    public function showc(CaracSportRepository $csr,$id): Response
    {
        return $this->render('carac/index.html.twig', [
            'carac' => $csr->findOneBy(array('id'=>$id)),
        ]);
    }

    /**
     * @Route("/suppCarac/{id}", name="suppCarac")
     */
    public function supprimerCarac(CaracSport  $c): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($c);
        $em->flush();

        return $this->redirectToRoute('app_carac');
    }

    /**
     * @Route("/modifCarac/{id}", name="modifCarac")
     */
    public function modifierCarac($id,Request $request): Response
    {
        $carac = $this->getDoctrine()->getManager()->getRepository(CaracSport::class)->find($id);

        $form = $this->createForm(CaracType::class,$carac);

        $form->handleRequest($request);

        $cm = new caracMetier();
        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush($cm->calculCarac($carac));

            return $this->redirectToRoute('app_carac');
        }
        return $this->render('carac/updateCarac.html.twig',['f'=>$form->createView()]);

    }

    //----------------------------Json---------------------------------

    /**
     * @Route("/j/caracs", name="app_carac_j")
     */
    public function indexJ(NormalizerInterface $normalizer,CaracSportRepository $csr): Response
    {

        $caracs= $csr->findAll();
        $jsonContent = $normalizer->normalize($caracs, 'json', ['groups' => 'post:read']);

        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/j/addCarac", name="addCarac_j")
     */
    public function addCaracJ(NormalizerInterface $normalizer): Response
    {
        $carac = new CaracSport();

        $em = $this->getDoctrine()->getManager();
        $em->persist($carac);
        $em->flush();
        $c = $normalizer->normalize($carac, 'json', ['groups' => 'post:read']);

        return new Response(json_encode($c));
    }

    /**
     * @Route("/j/carac/{id}", name="c_show_j", methods={"GET"})
     */
    public function showcJ(NormalizerInterface  $normalizer,CaracSportRepository $csr,$id): Response
    {
        $carac = $csr->find($id);
        $jsonContent = $normalizer->normalize($carac, 'json', ['groups' => 'post:read']);
        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/j/suppCarac/{id}", name="suppCarac_j")
     */
    public function supprimerCaracJ(NormalizerInterface  $normalizer,CaracSport  $c): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($c);
        $em->flush();
        $jsonContent = $normalizer->normalize($c, 'json', ['groups' => 'post:read']);

        return new Response("Caracteristique supprimé" . json_encode($jsonContent));
    }

    /**
     * @Route("/j/modifCarac/{id}", name="modifCarac_j")
     */
    public function modifierCaracJ(NormalizerInterface $normalizer,$id,Request $request): Response
    {
        $carac = $this->getDoctrine()->getManager()->getRepository(CaracSport::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $carac->setProtNeeds($request->get('prot'));
        $carac->setCalorieNeed($request->get('cal'));
        $carac->setAge($request->get('age'));
        $carac->setTaille($request->get('taille'));
        $carac->setPoids($request->get('poids'));
        $carac->setGenre($request->get('genre'));

        $em->flush();
        $c = $normalizer->normalize($carac, 'json', ['groups' => 'post:read']);

        return new Response("Modifié avec succes".json_encode($c));
    }
}
