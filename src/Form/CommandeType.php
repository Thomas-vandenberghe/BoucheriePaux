<?php

namespace App\Form;

use DateTime;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $user = $options['user'];

        $builder
            ->add('finishedAt', TextType::class,[
                'label'=> false,
                'required'=> true,
                'attr'=>[
                    'class'=>'datepicker',
                'readonly'=>true,
                    

                ]
            ])          

        ->add('submit', SubmitType::class,[
            'label'=>'Valider cette date',
            'attr'=>[
                'class'=>'btn btn-connexion mt-3 d-flex justify-content-center mx-auto'
            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'user'=> array(),
        ]);
    }
}
