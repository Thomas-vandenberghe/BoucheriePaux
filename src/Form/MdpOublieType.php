<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class MdpOublieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('password', RepeatedType::class, [
            'type'=> PasswordType::class,
            'invalid_message'=> 'Le mot de passe et la confirmation doivent être identiques.',

            'required' => true,
            'first_options'=> [
                'label' => 'Mon nouveau mot de passe',
                'constraints' => new Length(null, 8, 55),
                'constraints' => new Regex([
                    'pattern' => '/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[#?!@$%^&*-]).{8,}$/',
                    'message' => 'Doit contenir au moins 8 caractères dont une majuscule et un symbole parmi cette liste : #?!@$%^&-= ',
                    ]),
                'attr' => [
                    'placeholder' => 'Merci de saisir votre nouveau mot de passe'
                    ]
            ],
            'second_options' => [
                'label' => 'Confirmez votre nouveau mot de passe',
                'constraints' => new Length(null, 8, 55),
                'constraints' => new Regex([
                    'pattern' => '/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[#?!@$%^&*-]).{8,}$/',
                    'message' => 'Doit contenir au moins 8 caractères dont une majuscule et un symbole parmi cette liste : #?!@$%^&-= ',
                    ]),
                'attr' => [
                'placeholder' => 'Merci confirmer votre nouveau mot de passe'
            ]
            ],
        ])
        ->add('submit', SubmitType::class, [
            'label' => "Mettre à jour",
            'attr' => [
                'class'=>'btn btn-connexion btn-centre' 
            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
