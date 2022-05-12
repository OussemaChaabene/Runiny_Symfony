<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Mailer\MailerInterface;
use App\Mail\MailerApi;
use App\Entity\User;
use App\Form\User1Type;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class SecurityController extends AbstractController
{
    /**
     * @Route("/addUserJ", name="addUser")
     */
    public function addUserJ(Request $request, NormalizerInterface $normalizer): Response
    {

        $users = new user();
        $u = $normalizer->normalize($users, 'json', ['groups' => 'post:read']);
        $em = $this->getDoctrine()->getManager();
        $users->setEmail((string)$request->get('Email'));
        $users->setPassword((string)$request->get('Password'));
        $em->persist($users);
        $em->flush();


        return new Response(json_encode($u));
    }
    /**
     * @Route("/SignInJ", name="SignInJ")
     */
    public function SignInJ(Request $request): Response
    {
        $users = new user();
        $email = $request->query->get("email");
        $password = $request->query->get("password");
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository(User::class)->findOneBy(['email' => $email]);
        if ($users) {
            if (password_verify($password, $users->getPassword())) {
                $serializer = new Serializer([new ObjectNormalizer()]);
                $formatted = $serializer->normalize($users);
                return new JsonResponse($formatted);
            } else {
                return new Response("password not found");
            }
        } else {
            return new Response("user not found");
        }
    }
    /**
     * @Route("/modifierUser/{id}", name="modifierUser")
     */
    public function modifierUser(NormalizerInterface $normalizer, $id, Request $request): Response
    {
        $users = $this->getDoctrine()->getManager()->getRepository(User::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $users->setEmail((string)$request->get('Email'));
        $users->setPassword((string)$request->get('Password'));

        $em->flush();
        $m = $normalizer->normalize($users, 'json', ['groups' => 'post:read']);

        return new Response("Modifié avec succes" . json_encode($m));
    }


    /**
     * @Route("/register", name="app_user_signup", methods={"GET", "POST"})
     */
    public function new(Request $request, UserRepository $userRepository, UserPasswordEncoderInterface $passwordEncoder, MailerInterface $mailer): Response
    {
        $user = new User();
        $form = $this->createForm(User1Type::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $passwordEncoder->encodePassword($user, $user->getPassword())
            );

            $userRepository->add($user);
            $email = new MailerApi();
            $email->sendEmail($mailer, 'testapimail63@gmail.com', $user, 'testing email', 'User ajouté avec success');
            return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/signup.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
