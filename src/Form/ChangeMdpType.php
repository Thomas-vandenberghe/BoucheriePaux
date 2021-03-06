<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class ChangeMdpType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'disabled' => true,
                'label' => "Mon adresse email"
            ])
            
            ->add('firstname', TextType::class, [
                'disabled' =>true,
                'label' => "Mon prénom"
            ])
            ->add('lastname' , TextType::class, [
                'disabled' =>true,
                'label' => "Mon nom"             
            ])
            ->add('old_password', PasswordType::class, [
                'label' => 'Mon mot de passe actuel',
                'constraints' => new Length(null, 2, 55),
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'Veuillez saisir votre mot de passe actuel'
                ]
            ])
            ->add('new_password', RepeatedType::class, [
                'type'=> PasswordType::class,
                'mapped' => false,
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
                        'placeholder' => 'Merci de saisir un nouveau mot de passe'
                        ]
                ],
                'second_options' => [
                    'label' => 'Confirmez le nouveau mot de passe',
                    'constraints' => new Length(null, 8, 55),
                'constraints' => new Regex([
                    'pattern' => '/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[#?!@$%^&*-]).{8,}$/',
                    'message' => 'Doit contenir au moins 8 caractères dont une majuscule et un symbole parmi cette liste : #?!@$%^&-= ',
                    ]),               
                'attr' => [
                    'placeholder' => 'Merci de confirmer votre nouveau mot de passe'
                ]
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Mettre à jour",
                'attr' => [
                    'class' => 'btn btn-connexion d-flex justify-item-center mx-auto mt-5'
                ]
                
            ])
            ;
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
