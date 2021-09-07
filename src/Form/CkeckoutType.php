<?php

namespace App\Form;

use App\Entity\Adresses;
use App\Entity\Transporteur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CkeckoutType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $options['user'];

        $builder
            ->add('adresse' ,EntityType::class,[
                'class'=> Adresses::class,
                'required'=>true,

                'multiple'=> false,
                'expanded'=> true
            ])
            ->add('transporteur',EntityType::class,[
                'class'=> Transporteur::class,
                'required'=>true,
                'multiple'=> false,
                'expanded'=> true
            ])
            ->add('information', TextareaType::class ,[
                'required'=>false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
            'user'=>array(),
        ]);
    }
}
