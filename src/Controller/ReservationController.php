<?php

namespace App\Controller;
use App\Entity\Reservation;
use App\Form\Reservation1Type;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * @Route("/reservation")
 */
class ReservationController extends AbstractController
{
    //codename one functions

    /**
     * @Route("/allReservations", name="AllReservations")
     */
    public function allReservations(NormalizerInterface $normalizer): Response
    {
        $repository = $this->getDoctrine()->getRepository(reservation::class);
        $reservations = $repository->findAll();
        $jsonContent = $normalizer->normalize($reservations, 'json', ['groups' => 'post:read']);
        return new Response(json_encode($jsonContent));
    }
    /**
     * @Route("/deleteReservationsJSON", name="deleteReservationsJSON")
     */
    public function deleteReservationsJSON(Request $request,NormalizerInterface $normalizer,$id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $reservations = $em->getRepository(Reservation::class)->find($id);
        $repository = $this->getDoctrine()->getRepository(reservation::class);
        $reservations = $repository->findAll();
        $jsonContent = $normalizer->normalize($reservations, 'json', ['groups' => 'post:read']);
        return new Response(json_encode($jsonContent));
    }

    //Symfony functions


    /**
     * @Route("/", name="app_reservation_index", methods={"GET"})
     */
    public function index(Request $request, EntityManagerInterface $entityManager, PaginatorInterface $paginator): Response
    {
        $reservations = $entityManager
            ->getRepository(Reservation::class)
            ->findAll();
        $reservations = $paginator->paginate(
            $reservations,
            $request->query->getInt('page', 1),
            3);
        return $this->render('reservation/index.html.twig', [
            'reservations' => $reservations,
        ]);
    }

    /**
     * @Route("/liste", name="app_reservation_liste", methods={"GET"})
     */
    public function liste(EntityManagerInterface $entityManager): Response
    {
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        $reservations = $entityManager
            ->getRepository(Reservation::class)
            ->findAll();

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('reservation/liste.html.twig', [
            'reservations' => $reservations,
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
     * @Route("/new", name="app_reservation_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reservation = new Reservation();
        $form = $this->createForm(Reservation1Type::class, $reservation);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reservation);
            $entityManager->flush();

            return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reservation/new.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idReser}", name="app_reservation_show", methods={"GET"})
     */
    public function show(Reservation $reservation): Response
    {
        return $this->render('reservation/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    /**
     * @Route("/{idReser}/edit", name="app_reservation_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Reservation1Type::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reservation/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idReser}", name="app_reservation_delete", methods={"POST"})
     */
    public function delete(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $reservation->getIdReser(), $request->request->get('_token'))) {
            $entityManager->remove($reservation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
    }


}