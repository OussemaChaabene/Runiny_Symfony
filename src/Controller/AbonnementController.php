<?php

namespace App\Controller;

use App\Entity\Abonnement;
use App\Form\AbonnementType;
use App\Repository\AbonnementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Dompdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Options;
use Symfony\Component\Mime\Email;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * @Route("/categorieabo")
            */
class AbonnementController extends AbstractController
{
    /**
     * @Route("/", name="app_abonnement_index", methods={"GET"})
     */
    public function index(Request $request,AbonnementRepository $abonnementRepository,PaginatorInterface $paginator): Response
    {
        $donnees = $abonnementRepository->findAll();
        $abonnements = $paginator->paginate(
            $donnees, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            4 // Nombre de résultats par page
        );
        return $this->render('abonnement/index.html.twig', [
            'abonnements' =>  $abonnements,
        ]);
    }

    /**
     * @Route("/new", name="app_abonnement_new", methods={"GET", "POST"})
     */
    public function new(MailerInterface $mailer,Request $request, AbonnementRepository $abonnementRepository): Response
    {
        $abonnement = new Abonnement();
        $form = $this->createForm(AbonnementType::class, $abonnement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $abonnementRepository->add($abonnement);
            $email = (new Email())
                ->from(Address::create('RUNNINY <leila.bencheikh@esprit.tn>'))
                ->to("leila.bencheikh@esprit.tn")
                ->subject('Nouvelle catégorie')
                ->html('
                <center><h1>Bonjour '.$abonnement->getAbNom().' à '.$abonnement->getAbPrix().' DT ,</h1></center>
                <p>Cette catégorie a été ajoutée récemment.</p>
                
                
                ');
            $mailer->send($email);
            return $this->redirectToRoute('app_abonnement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('abonnement/new.html.twig', [
            'abonnement' => $abonnement,
            'form' => $form->createView(),
        ]);
    }

   /**
     * @Route("/{id}", name="app_abonnement_show", methods={"GET"})
     */
    public function show(Abonnement $abonnement): Response
    {
        return $this->render('abonnement/show.html.twig', [
            'abonnement' => $abonnement,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_abonnement_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Abonnement $abonnement, AbonnementRepository $abonnementRepository): Response
    {
        $form = $this->createForm(AbonnementType::class, $abonnement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $abonnementRepository->add($abonnement);
            return $this->redirectToRoute('app_abonnement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('abonnement/edit.html.twig', [
            'abonnement' => $abonnement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_abonnement_delete", methods={"POST"})
     */
    public function delete(Request $request, Abonnement $abonnement, AbonnementRepository $abonnementRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$abonnement->getId(), $request->request->get('_token'))) {
            $abonnementRepository->remove($abonnement);
        }

        return $this->redirectToRoute('', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/DownloadProduitsData", name="DownloadProduitsData")
     */
    public function DownloadProduitsData(AbonnementRepository $repository)
    {
        $abonnement=$repository->findAll();

        // On définit les options du PDF
        $pdfOptions = new Options();
        // Police par défaut
        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->setIsRemoteEnabled(true);

        // On instancie Dompdf
        $dompdf = new Dompdf($pdfOptions);
        $context = stream_context_create([
            'ssl' => [
                'verify_peer' => FALSE,
                'verify_peer_name' => FALSE,
                'allow_self_signed' => TRUE
            ]
        ]);
        $dompdf->setHttpContext($context);

        // On génère le html
        $html = $this->renderView('abonnement/pdf.html.twig',
            ['abonnement'=>$abonnement ]);


        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // On génère un nom de fichier
        $fichier = 'Tableau des abonnement.pdf';

        // On envoie le PDF au navigateur
        $dompdf->stream($fichier, [
            'Attachment' => true
        ]);

        return new Response();
    }
/*
    /**
     * @Route("/lili", name="lili")
     */

    /*public function indexMobile(EntityManagerInterface $entityManager,NormalizerInterface $normalizer,AbonnementRepository $ar): Response
    {

        $Abonnements = $ar ->findAll();
        $abonnement = $normalizer ->normalize($Abonnements,'json',['groups'=>'post:read']);

        return new Response(json_encode($abonnement));
    }*/
}