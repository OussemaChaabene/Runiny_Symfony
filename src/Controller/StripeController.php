<?php

namespace App\Controller;

use App\Entity\Payement;
use App\Repository\PayementRepository;
use phpDocumentor\Reflection\Types\Integer;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/checkout/{p}/{a}", name="checkout")
     */
    public function checkout(Request $request): Response
    {
        $p = $request->attributes->get('p');
        $a = $request->attributes->get('a');

        Stripe::setApiKey('sk_test_51KXm6wLAejZKeZY42sNEV6Jnyd4fuDKfQ3vBYkpEaG9S1By5Jmk49lU7GndMSLCsezL0ONL4QjgzfK3sE0aUubBc00SdY1uwBg');


        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items'           => [
                [
                    'price_data' => [
                        'currency'     => 'eur',
                        'product_data' => [
                            'name' => $a,
                        ],
                        'unit_amount'  => $p,
                    ],
                    'quantity'   => 1,
                ]
            ],
            'mode'                 => 'payment',
            'success_url'          => $this->generateUrl('success_url', ['p'=>$p], UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url'           => $this->generateUrl('cancel_url', [], UrlGeneratorInterface::ABSOLUTE_URL),
        ]);

        return $this->redirect($session->url, 303);
    }

    /**
     * @Route("/success-url/{p}", name="success_url")
     */
    public function successUrl(PayementRepository $prp,Request $request/*,UserRespo $up*/): Response
    {
        $p = new Payement();
        $pr = $request->attributes->get('p');
        $p->setMontant($pr);

        $time = new \DateTime();
        $time->format('m/d/Y');

        $p->setDatePay($time->format('m/d/Y'));

        /*$p->getIdUser($up->findOneBy(array(sessionid)));*/
        $prp->add($p);
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
