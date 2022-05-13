<?php

namespace App\Controller;

use App\Entity\Mail;
use App\Form\MailType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class MailController extends AbstractController
{
    /**
     * @Route("/mail", name="mail")
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function sendMail(Request $request,MailerInterface $mailer)
    {
        $mail = new Mail();
        $form = $this->createForm(MailType::class, $mail);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $subject = $mail->getSubject();
            $mail = $mail->getMail();
            $object = $form['object']->getData();
            $username='raiedbejaoui22@gmail.com';
            $transport = Transport::fromDsn('smtp://raiedbejaoui:raied1995@smtp.gmail.com:465');
            $mailer = new Mailer($transport);
            $email = (new Email())
                ->from($username)
                ->to( $mail)

                ->subject( $subject)
                ->text($object);


            $mailer->send($email);

            return $this->redirectToRoute('base-front.html.twig');

        }

        return $this->render('mail/essayer.html.twig', [
            'mail' => $mail,
            'form' => $form->createView(),
        ]);
    }
}
