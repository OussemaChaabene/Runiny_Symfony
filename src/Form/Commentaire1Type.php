<?php

namespace App\Form;

use App\Entity\Commentaire;
use App\Entity\Publication;
use App\Repository\PublicationRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Commentaire1Type extends AbstractType
{
    private $PublicationRepository;
    public function __construct(PublicationRepository $PublicationRepository)
    {
        $this->PublicationRepository = $PublicationRepository;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('comment')
            ->add('date_com')
            ->add('note')

            ->add('idPublication', EntityType::class, [
                'class' => Publication::class,
                'choice_label' => function(Publication $publication) {
                    return $publication->getId();
                },
                'placeholder' => 'Choose a publication',
                'choices' => $this->PublicationRepository->findAll()
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commentaire::class,
        ]);
    }
}
