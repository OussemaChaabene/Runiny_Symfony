<?php

namespace App\Controller;

use App\Entity\Events;
use App\Entity\Participant;
use App\Entity\User;
use App\Form\EventsType;
use App\Form\ParticipantType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * @Route("/events")
 */
class EventsController extends AbstractController
{
    /**
     * @Route("/", name="app_events_index", methods={"GET"})
     */
    public function index(Request $request,PaginatorInterface $paginator)
    {

        $donnees=$this->getDoctrine()->getRepository(Events::class) ->findAll();
        $events = $paginator->paginate(
            $donnees,
            $request->query->getInt('page', 1),
            3
        );



        return $this->render('events/index.html.twig', [
            'events' => $events,
        ]);
    }
    /**
     * @Route("/home", name="app_events_index1", methods={"GET"})
     */
    public function index1(Request $request,PaginatorInterface $paginator)
    {

        $donnees=$this->getDoctrine()->getRepository(Events::class) ->findAll();
             $events = $paginator->paginate(
                 $donnees,
                 $request->query->getInt('page', 1),
                 3
    );



        return $this->render('events/index2.html.twig', [
            'events' => $events,
        ]);
    }

    /**
     * @Route("/new", name="app_events_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $event = new Events();
        $form = $this->createForm(EventsType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($event);
            $entityManager->flush();

            return $this->redirectToRoute('app_events_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('events/new.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/newParticipant/{idEven}", name="app_events_new_participant", methods={"GET", "POST"})
     */
    public function newParticipant($idEven,Request $request, EntityManagerInterface $entityManager): Response
    {
        $part = $this->getDoctrine()->getRepository(User::class)->find(13);
        $even = $this->getDoctrine()->getRepository(Events::class)->find($idEven);
        $participant = new Participant();
        $participant->setIdeven($even);
        $participant->setIdUser($part->getIdUser());
        $entityManager->persist($participant);
        $entityManager->flush();

        return $this->render('participant/response_participation.html.twig');
    }

    /**
     * @Route("/liste" ,name="app_reservation_liste", methods={"GET"})
     */

    public function liste( EntityManagerInterface $entityManager): Response
    {
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        $evenement = $entityManager
            ->getRepository(Events::class)
            ->find(1);
        $user = $entityManager
            ->getRepository(User::class)
            ->find(14);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('events/liste.html.twig', [

            'user' => $user,
            'events' => $evenement,
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
     * @Route("/{ideven}", name="app_events_show", methods={"GET"})
     */
    public function show(Events $event): Response
    {
        return $this->render('events/show.html.twig', [
            'event' => $event,
        ]);
    }

    /**
     * @Route("/{ideven}/edit", name="app_events_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Events $event, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EventsType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_events_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('events/edit.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{ideven}", name="app_events_delete", methods={"POST"})
     */
    public function delete(Request $request, Events $event, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$event->getIdeven(), $request->request->get('_token'))) {
            $entityManager->remove($event);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_events_index', [], Response::HTTP_SEE_OTHER);
    }
}
