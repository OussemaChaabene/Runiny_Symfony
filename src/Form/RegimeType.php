<?php

namespace App\Form;

use App\Entity\Plat;
use App\Entity\Regime;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegimeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('type', ChoiceType::class, [
    'choices' => [
        'Perte de poids' => 'Perte de poids',
        'Gain de poids' => 'Gain de poids',]
    ])
            ->add('niveau',ChoiceType::class, [
                'choices'  => [
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                ],
            ])
            ->add('plat', EntityType::class, [
                'class' => Plat::class,
                'multiple' => true,
                'expanded' => true,
                'choice_label' => 'nom',

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Regime::class,
        ]);
    }
}
