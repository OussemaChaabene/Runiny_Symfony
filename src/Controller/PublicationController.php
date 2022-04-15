<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Publication;
use App\Form\CommentaireType;
use App\Form\PublicationType;
use App\Repository\PublicationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
    public function indexF(PublicationRepository $publicationRepository): Response
    {
        return $this->render('publication/front-pub.html.twig', [
            'publications' => $publicationRepository->findAll(),
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
    { $commentaires = $entityManager
        ->getRepository(Commentaire::class)
        ->findBy(['idPublication'=>$id]);
        $query=$entityManager
            ->createQuery("select count(s) from App\Entity\Commentaire s where s.idPublication=:id  ")
            ->setParameter('id',$id);
        $number=$query->getSingleScalarResult();


        $commentaires2 = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaires2);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $commentaires2->setIdPublication($publication);
            $entityManager->persist($commentaires2);
            $entityManager->flush();

            return $this->redirectToRoute('app_publicationF_index');
        }
        return $this->render('publication/show_front.html.twig', [
            'publication' => $publication,'commentaires'=>$commentaires,'commentairesform'=>$commentaires2,
            'form' => $form->createView(),'idpub'=>$id,'number'=>$number,
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
}
