<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('rating', IntegerType::class,['label'=>'note sur 5','attr'=>['placeholder'=>"donner une note allant de 0 à 5",'max'=>5,'min'=>0,'step'=>1]])
            ->add('content', TextareaType::class,['label'=>'votre avis','attr'=>['placeholder'=>"votre avis aidera les futurs personnes qui vont reservées"] ])


        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
