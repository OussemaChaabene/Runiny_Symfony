<?php

namespace App\Controller;

use phpDocumentor\Reflection\Types\Integer;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


class StripeController extends AbstractController
{

    /**
     * @Route("/stripe", name="app_stripe")
     */
    public function index(): Response
    {
        return $this->render('stripe/index.html.twig', [
            'controller_name' => 'StripeController',
        ]);
    }

    /**
     * @Route("/checkout", name="checkout")
     */
    public function checkout(): Response
    {
        Stripe::setApiKey('sk_test_51KXm6wLAejZKeZY42sNEV6Jnyd4fuDKfQ3vBYkpEaG9S1By5Jmk49lU7GndMSLCsezL0ONL4QjgzfK3sE0aUubBc00SdY1uwBg');


        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items'           => [
                [
                    'price_data' => [
                        'currency'     => 'eur',
                        'product_data' => [
                            'name' => 'Abonnement prenuim',
                        ],
                        'unit_amount'  => 3000,
                    ],
                    'quantity'   => 1,
                ]
            ],
            'mode'                 => 'payment',
            'success_url'          => $this->generateUrl('success_url', [], UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url'           => $this->generateUrl('cancel_url', [], UrlGeneratorInterface::ABSOLUTE_URL),
        ]);

        return $this->redirect($session->url, 303);
    }

    /**
     * @Route("/success-url", name="success_url")
     */
    public function successUrl(): Response
    {
        return $this->render('payement/success.html.twig', []);
    }

    /**
     * @Route("/cancel-url", name="cancel_url")
     */
    public function cancelUrl(): Response
    {
        return $this->render('payement/cancel.html.twig', []);
    }
}
