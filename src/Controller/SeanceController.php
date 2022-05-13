<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\Seance;
use App\Form\SeanceType;
use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
use PhpParser\Node\Scalar\String_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * @Route("/seance")
 */
class SeanceController extends AbstractController
{
//codename one functions

    /**
     * @Route("/allSeance", name="allseance")
     */
    public function allSeance(NormalizerInterface $normalizer): Response
    {
        $repository = $this->getDoctrine()->getRepository(Seance::class);
        $Seances = $repository->findAll();
        $jsonContent = $normalizer->normalize($Seances, 'json', ['groups' => 'post:read']);
        return new Response(json_encode($jsonContent));
    }

    public function SeanceId(Request $request,$id,NormalizerInterface $normalizer){
        $em = $this->getDoctrine()->getManager();
        $seances = $em->getRepository(Seance::class)->find($id);

        $jsonContent = $normalizer->normalize($seances,'json',['groups'=>'post:read']);
        return new Response(json_encode($jsonContent));
    }
    /**
     * @Route("/addSeanceJSON", name="addSeanceJSON")
     */
    public function addSeanceJSON(Request $request,NormalizerInterface $normalizer): Response
    {

        $seance = new Seance();
        $em = $this->getDoctrine()->getManager();
        $date=date_create_from_format('Y-m-d',date('Y-m-d',strtotime($request->get('date'))));
        $seance->setDate($date);
        $seance->setTypeSeance($request->get('typeSeance'));
        $em->persist($seance);
        $em->flush();
        $jsonContent = $normalizer->normalize($seance, 'json', ['groups' => 'post:read']);

        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/deleteSeanceJSON/{id}", name="deleteSeanceJSON")
     */
    public function deleteSeanceJSON(Request $request,NormalizerInterface $normalizer,$id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $seances = $em->getRepository(Seance::class)->find($id);
        $em->remove($seances);
        $em->flush();
        $jsonContent = $normalizer->normalize($seances, 'json', ['groups' => 'post:read']);
        return new Response(json_encode($jsonContent));
    }

    //Symfony functions


    /**
     * @Route("/", name="app_seance_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $seances = $entityManager
            ->getRepository(Seance::class)
            ->findAll();

        return $this->render('seance/index.html.twig', [
            'seances' => $seances,
        ]);
    }
    public function liste(EntityManagerInterface $entityManager): Response
    {
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        $reservations = $entityManager
            ->getRepository(Seance::class)
            ->findAll();

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('seance/listseance.html.twig', [
            'seance' => $seance,
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => false
        ]);



    }

    /**
     * @Route("/new", name="app_seance_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $seance = new Seance();
        $form = $this->createForm(SeanceType::class, $seance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($seance);
            $entityManager->flush();

            return $this->redirectToRoute('app_seance_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('seance/new.html.twig', [
            'seance' => $seance,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idSeance}", name="app_seance_show", methods={"GET"})
     */
    public function show(Seance $seance): Response
    {
        return $this->render('seance/show.html.twig', [
            'seance' => $seance,
        ]);
    }

    /**
     * @Route("/{idSeance}/edit", name="app_seance_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Seance $seance, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SeanceType::class, $seance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_seance_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('seance/edit.html.twig', [
            'seance' => $seance,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idSeance}", name="app_seance_delete", methods={"POST"})
     */
    public function delete(Request $request, Seance $seance, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$seance->getIdSeance(), $request->request->get('_token'))) {
            $entityManager->remove($seance);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_seance_index', [], Response::HTTP_SEE_OTHER);
    }
}
