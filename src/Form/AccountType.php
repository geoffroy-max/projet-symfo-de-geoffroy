<?php

namespace App\Form;

use App\Entity\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName',TextType::class,['label'=>"prénom" ,'attr'=>['placeholder'=>"votre prénom..."]])
            ->add('lastName',TextType::class,['label'=>"nom",'attr'=>['placeholder'=> "votre nom..."]])
            ->add('email',EmailType::class,['label'=>"email",'attr'=>['placeholder'=>"votre email..."]])
            ->add('picture',UrlType::class,['label'=>"photo de profil",'attr'=>['placeholder'=>"votre Url..."]])

            ->add('introduction',TextType::class,['label'=>"introduction",'attr'=>['placeholder'=>"présenter vous en quelque mots..."]])
            ->add('description',TextareaType::class,['label'=>"description",'attr'=>['placeholder'=>"presenter vous en detaille..."]])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

}
