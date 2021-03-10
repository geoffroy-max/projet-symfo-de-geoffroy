<?php

namespace App\Form;

use App\Entity\Booking1;

use App\Form\DataTransformer\frenchDataTransformer;
use Symfony\Component\Form\Extension\Core\Type\DateType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Booking1Type extends AbstractType
{
private $transformer;

    public function __construct(frenchDataTransformer $transformer){
$this->transformer = $transformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startDate',TextType::class,['label'=>'date prevue pour arriver','attr'=>['placeholder'=>"reservez pour la date d'arriver"],
                 ] )
            ->add('endDate', TextType::class,['label'=>'date de depart','attr'=>['placeholder'=>"reservez pour la date de depart"],
                 ])
            ->add('comment',TextareaType::class,['label'=>false,'attr'=>['placeholder'=> "laisser un commentaire"],"required"=> false])

        ;
        $builder->get('startDate')->addModelTransformer($this->transformer);
        $builder->get('endDate')-> addModelTransformer($this->transformer);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking1::class,
            'validation_groups'=> [ 'Default' ,'front']
        ]);
    }
}
