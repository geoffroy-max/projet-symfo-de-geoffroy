<?php

namespace App\Form;

use App\Entity\Ad;

use http\Url;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class AdType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',TextType::class,[
               'label'=>'titre',  'attr'=>[
                   'placeholder'=>" le titre de l 'annonce"]
            ])

            ->add('slug',TextType::class,[
                'label'=> "l'adresse web ou slug", 'attr'=>[
                    'placeholder'=>"tapez l'adresse web"
                ]
            ,'required'=> false] )

            ->add('price',MoneyType::class,[
        'label'=> "prix par nuit", 'attr'=>[
            'placeholder'=>"indiquez le prix par nuit"
        ]
    ])
            ->add('introduction',TextType::class,[
        'label'=> 'description ou introduction', 'attr'=>[
            'placeholder'=>"description globale de  l'annonce"
        ]
    ])
            ->add('content',TextareaType::class,[
        'label'=> "description detaille de l'annonce", 'attr'=>[
            'placeholder'=>"tapez une description qui donne vraiment envi de venir chez vous"
        ]
    ])
            ->add('coverImage',UrlType::class,[
        'label'=> "l'url de l'image", 'attr'=>[
            'placeholder'=>"donner l'image qui donne vraiment envi"
        ]
    ])
            ->add('rooms',IntegerType::class,[
        'label'=> "nombres de chambres", 'attr'=>[
            'placeholder'=>" nombres de chambres disponibles"
        ]
    ])
            ->add('images', CollectionType::class,[

                    'entry_type'=> ImageType::class,
                    'allow_add'=>'true',
                    'allow_delete'=>'true'
                ]

            )

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
