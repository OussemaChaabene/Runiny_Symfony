<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Publication;
use App\Form\CommentaireType;
use App\Form\PublicationType;
use App\Repository\PublicationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Gedmo\Sluggable\Util\Urlizer;
use mofodojodino\ProfanityFilter\Check;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/publication")
 */
class PublicationController extends AbstractController
{
    /**
     * @Route("/", name="app_publication_index", methods={"GET"})
     */
    public function index(PublicationRepository $publicationRepository): Response
    {
        return $this->render('publication/index.html.twig', [
            'publications' => $publicationRepository->findAll(),
        ]);
    }
    /**
     * @Route("/front", name="app_publicationF_index", methods={"GET"})
     */
    public function indexF(EntityManagerInterface $entityManager ,Request $request, PaginatorInterface $paginator): Response
    {
        $publications = $paginator->paginate(
            $publications = $entityManager
                ->getRepository(Publication::class)
                ->findAll(),
            $request->query->getInt('page', 1),
            3
        );
        return $this->render('publication/front-pub.html.twig',[
            'publications' => $publications,
        ]);
    }

    /**
     * @Route("/new", name="app_publication_new", methods={"GET", "POST"})
     */
    public function new(Request $request, PublicationRepository $publicationRepository): Response
    {
        $publication = new Publication();
        $form = $this->createForm(PublicationType::class, $publication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $form['image']->getData();
            $lastFile = $publication->getImage();
            if ($form['image']->getData() == null){

                $publication->setImage($lastFile);
            }
            if ($uploadedFile) {
                $destination = $this->getParameter('kernel.project_dir') . '/public/image';
                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = Urlizer::urlize($originalFilename) . '-' . uniqid() . '.' . $uploadedFile->guessClientExtension();
                $uploadedFile->move(
                    $destination,
                    $newFilename
                );
                $publication->setImage($newFilename);
            }
            $publicationRepository->add($publication);
            return $this->redirectToRoute('app_publication_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('publication/new.html.twig', [
            'publication' => $publication,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_publication_show", methods={"GET"})
     */
    public function show(Publication $publication): Response
    {
        return $this->render('publication/show.html.twig', [
            'publication' => $publication,
        ]);
    }

    /**
     * @Route("/f/{id}", name="app_publication_front_show")
     */
    public function showfront(Publication $publication, EntityManagerInterface $entityManager,$id, Request $request): Response
    { $em=$this->getDoctrine()->getManager();
        $commentaires = $entityManager
        ->getRepository(Commentaire::class)
        ->findBy(['idPublication'=>$id]);
        $query=$entityManager
            ->createQuery("select count(s) from App\Entity\Commentaire s where s.idPublication=:id  ")
            ->setParameter('id',$id);
        $number=$query->getSingleScalarResult();
        $dql = "SELECT AVG(e.note) AS rating FROM App\Entity\Commentaire e "."WHERE e.idPublication = :id  ";
        $rating = $em->createQuery($dql)
            ->setParameter('id', $id)
            ->getSingleScalarResult();


        $check = new Check( '../config/profanities.php');
        $commentaires2 = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaires2);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $verifier = $form['comment']->getData();
            $hasProfanity = $check->hasProfanity($verifier);
            if ($hasProfanity == false) {
                $commentaires2->setIdPublication($publication);
                $entityManager->persist($commentaires2);
                $entityManager->flush();
                $good="good";
                return $this->redirectToRoute('app_publication_front_show',[
                    "id"=>$id,"good"=>$good
                ]);
            }else {
                $bad="bad";
                return $this->redirectToRoute('app_publication_front_show',[
                    "id"=>$id,"bad"=>$bad
                ]);
            }
        }
        return $this->render('publication/show_front.html.twig', [
            'publication' => $publication,'commentaires'=>$commentaires,'commentairesform'=>$commentaires2,
            'form' => $form->createView(),'idpub'=>$id,'number'=>$number,'rating'=>$rating,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_publication_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Publication $publication, PublicationRepository $publicationRepository): Response
    {
        $form = $this->createForm(PublicationType::class, $publication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $publicationRepository->add($publication);
            return $this->redirectToRoute('app_publication_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('publication/edit.html.twig', [
            'publication' => $publication,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_publication_delete", methods={"POST"})
     */
    public function delete(Request $request, Publication $publication, PublicationRepository $publicationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$publication->getId(), $request->request->get('_token'))) {
            $publicationRepository->remove($publication);
        }

        return $this->redirectToRoute('app_publication_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/DownloadProduitsData", name="DownloadProduitsData")
     */
    public function DownloadProduitsData(PublicationRepository $repository)
    {
        $Publication=$repository->findAll();

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
        $html = $this->renderView('publication/download.html.twig',
            ['Publication'=>$Publication ]);


        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // On génère un nom de fichier
        $fichier = 'Tableau des publication.pdf';

        // On envoie le PDF au navigateur
        $dompdf->stream($fichier, [
            'Attachment' => true
        ]);

        return new Response();
    }
}
