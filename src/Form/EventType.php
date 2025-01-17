<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de l\'événement',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un nom pour l\'événement.',
                    ])
                ],
            ])
            ->add('date', DateType::class, [
                'label' => 'Date de l\'événement',
                'widget' => 'single_text',
            'constraints' => [
                new NotBlank([
                    'message' => 'Veuillez entrer une date valide pour l\'événement.',
                ])
            ],
            ])
            ->add('orga', EntityType::class, [
            'label' => 'Organisateur',
                'class' => User::class,
            'choice_label' => 'username', // Afficher le nom d'utilisateur
            'constraints' => [
                new NotBlank([
                    'message' => 'Veuillez choisir un organisateur.',
                ])
            ],
            ])
            ->add('participants', EntityType::class, [
            'label' => 'Participants',
                'class' => User::class,
            'choice_label' => 'username', // Afficher le nom d'utilisateur
                'multiple' => true,
            'expanded' => true,  // Afficher les participants sous forme de cases à cocher
            'constraints' => [
                new NotBlank([
                    'message' => 'Veuillez choisir au moins un participant.',
                ])
            ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
