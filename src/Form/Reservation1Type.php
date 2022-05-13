<?php

namespace App\Form;

use App\Entity\Reservation;
use App\Entity\User;
use Doctrine\DBAL\Types\DateTimeType;
use Doctrine\DBAL\Types\IntegerType;
use phpDocumentor\Reflection\Types\False_;
use phpDocumentor\Reflection\Types\Integer;
use phpDocumentor\Reflection\Types\True_;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use function Sodium\add;

class Reservation1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        global $kernel;
        if('AppCache'==get_class($kernel)){
            $kernel=$kernel->getKernel();
        }
        $doctrine=$kernel->getContainer()->get('doctrine');
        $id=$doctrine->getRepository(User::class)->findBy(['role'=>'coach']);
        $doctrine->getC
        $builder
            ->add('idUser')
            ->add('idCoach',ChoiceType::class,['choices'=>$id])
            ->add('date')
            ->add('idSalle')

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
