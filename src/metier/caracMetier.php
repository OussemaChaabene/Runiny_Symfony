<?php

namespace App\metier;

use App\Controller\PayController;
use App\Entity\CaracSport;
use App\Entity\Payement;
use phpDocumentor\Reflection\Types\Integer;
use Stripe\Checkout\Session;
use Symfony\Component\HttpFoundation\Response;

class caracMetier
{
    public function calculCarac(CaracSport $cs){
        $cn =0;
        $pn=0;

        //0.8 x poids
        $pn=(2*$cs->getPoids());
        if($cs->getGenre()=="homme"){
            //$cn=(10 x $) + (6,25 x Taille en cm) - (5 x âge en années) + 5
            $cn=((10*$cs->getPoids())+(6.25*$cs->getTaille())-(5*$cs->getAge())+5);
        }else{
            $cn=((10*$cs->getPoids())+(6.25*$cs->getTaille())-(5*$cs->getAge())-161);
        }
        $cs->setCalorieNeed($cn);
        $cs->setProtNeeds($pn);
        return $cs;
    }



}