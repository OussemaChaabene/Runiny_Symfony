<?php

namespace App\Form;

use App\Entity\Mail;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('mail',EmailType::class,[
                "label"=> 'E-mail'
            ])
            ->add('subject',TextType::class,[
                "label"=> 'Sujet'
            ])

            ->add('object',TextType::class,[
                "label"=> 'Message'])

             ->add('envoyer',SubmitType::class);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Mail::class,
        ]);
    }
}
