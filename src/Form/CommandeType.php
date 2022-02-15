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
                'label'=> 'Date de retrait souhaitée',
                'required'=> true,
<<<<<<< HEAD
                'widget' => 'single_text',
                //   'html5' => false,
                  'attr' => ['class' => 'js-datepicker'],
                // 'expanded'=>true
            ])
=======
                'attr'=>[
                    'class'=>'datepicker'
                ]
            ])          

>>>>>>> e77d0a7e4d57a8b6b71bd80539d0712fa3606dc9
        ->add('submit', SubmitType::class,[
            'label'=>'Valider ma commande',
            'attr'=>[
                'class'=>'btn btn-success btn-block'
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
