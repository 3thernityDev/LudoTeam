<?php

namespace App\Form;

use App\Entity\Game;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class GameFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du jeu',
            'required' => true,
            'constraints' => [
                new NotBlank([
                    'message' => 'Veuillez saisir un nom de jeu',
                ]),
            ],
            'attr' => [
                'placeholder' => 'Monopoly',
            ],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Jeu de société',
                ],
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'Type de jeu',
                'choices' => [
                    'Jeu de plateau' => 'board_game',
                    'Jeu de carte' => 'card_game',
                    'Jeu de duel' => 'duel_game',
                ],
                'required' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
        ]);
    }
}
