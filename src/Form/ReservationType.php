<?php

namespace App\Form;

use App\Entity\Reservation;
use Doctrine\DBAL\Types\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('idCoach')
            ->add('idSalle')
            ->add('date', DateType::class, [
                'widget' => 'choice'
            ])
            ->add('tempsh', RangeType::class, [
                'attr' => [
                    'min' => 9,
                    'max' => 18
                ],
            ])
            ->add('tempsmin', RangeType::class, [
                'attr' => [
                    'min' => 00,
                    'max' => 59
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
