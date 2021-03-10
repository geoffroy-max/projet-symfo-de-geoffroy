<?php

namespace App\Form;

use App\Entity\Ad;
use App\Entity\Booking1;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminBooking1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startDate', DateType::class, ['label'=>"date d'arriver",'attr'=>['placeholder'=>"date prevue pour l'arriver"],'widget'=>"single_text"])
            ->add('endDate',DateType::class, ['label'=> "date de depart", 'attr'=>['placeholder'=>"date prevue pour le depart"],'widget'=>"single_text"])
            ->add('comment', TextareaType::class,['label'=>"commentaire", 'attr'=>['placeholder'=>"laissez un commentiare"]])
            ->add('booker', EntityType::class,['class'=>User::class, 'choice_label'=> function($user){
                return $user->getfirstname(). "". strtoupper($user->getlastname());
            }])
            ->add('ad', EntityType::class,['class'=>Ad::class,'choice_label'=>'title'])
            ;


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking1::class,
            'validation_groups'=>['Default']
        ]);
    }
}
