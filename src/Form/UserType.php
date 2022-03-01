<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
            $builder
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'constraints' => new Length(null, 2, 35),
                'constraints' => new Regex([
                'pattern' => '/[^a-zA-Z]$/',
                'match' => false,
                    'message' => 'Seules les lettres sont autorisées',
                ]),
                'attr' => [
                    'placeholder'=> 'Merci de saisir votre prénom'
                ]
            ])
            ->add('lastname', TextType::class,[
                'label'=> 'Nom',
                'constraints' => new Length(null, 2, 35),
                'constraints' => new Regex([
                    'pattern' => '/[^a-zA-Z]$/',
                    'match' => false,
                    'message' => 'Seules les lettres sont autorisées',
                ]),

                'attr' => [
                    'placeholder' =>'Merci de saisir votre nom'
                ]
            ])

            ->add('telephone', TelType::class,[
                'label' => 'Téléphone',
                'constraints' => new Length(null, 10, 15),
                'attr' =>  [
                    'placeholder' => 'Entrez votre numéro de téléphone'
                            ]
                ])


            ->add('email', EmailType::class, [
                'label' => 'Email',
                'constraints' => new Length(null, 2, 55),
                'attr' => [
                    'placeholder' => 'Merci de saisir votre adresse email'
                ]
            ])


            ->add('password', RepeatedType::class, [
                'type'=> PasswordType::class,
                'invalid_message'=> 'Le mot de passe et la confirmation doivent être identiques.',

                'required' => true,
                'first_options'=> [
                    'label' => 'Mot de passe',
                    'constraints' => new Length(null, 8, 55),
                    'constraints' => new Regex([
                    'pattern' => '/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[#?!@$%^&*-]).{8,}$/',
                    'message' => 'Doit contenir au moins 8 caractères dont une majuscule et un symbole parmi cette liste : #?!@$%^&-= ',
                    ]),
                    'attr' => [
                        'placeholder' => 'Merci de saisir un mot de passe'
                        ]
                ],
                'second_options' => [
                    'label' => 'Confirmez le mot de passe',
                    'constraints' => new Length(null, 8, 55),
                    'constraints' => new Regex([
                        'pattern' => '/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[#?!@$%^&*-]).{8,}$/',
                        ]),
                'attr' => [
                    'placeholder' => 'Merci confirmer votre mot de passe'
                ]
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => "S'inscrire",
                'attr' => [
                    'class'=>'btn btn-connexion btn-centre' 
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
