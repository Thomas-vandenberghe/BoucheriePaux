<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $user = $options['user'];

        $builder
            ->add('finishedAt', DateType::class,[
                'label'=> 'Date de retrait souhaitée',
                'required'=> true,
                // 'expanded'=>true
            ])
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
            'user'=> array()
        ]);
    }
}
