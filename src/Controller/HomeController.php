<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Form\UserSignupType;
use App\Form\UserLoginType;
use App\Mail\MailerApi;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(): Response
    {
        return $this->render('indexx.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    /**
     * @Route("/signup", name="app_home_signup")
     */
    public function signup(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
        $user = new User();
        $form = $this->createForm(UserSignupType::class, $user);
        $user->setRole('client');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();
            $email = new MailerApi();
            $email->sendEmail($mailer, 'testapimail63@gmail.com', 'sami.abdelkarim@esprit.tn', 'testing email', 'User ajouté avec success');
            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/signup_home.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/signin", name="app_home_login")
     */
    public function login(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
        $user = new User();
        $form = $this->createForm(UserLoginType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();
            $email = new MailerApi();
            $email->sendEmail($mailer, 'testapimail63@gmail.com', 'sami.abdelkarim@esprit.tn', 'testing email', 'User ajouté avec success');
            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/signup_home.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}
