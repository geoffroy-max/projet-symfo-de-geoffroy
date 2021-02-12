<?php
namespace App\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class frenchDataTransformer implements DataTransformerInterface
{

    public function transform($date)
    { if ($date === null) {
        return '';
    }
        return $date->format('d/m/Y');
    }

    public function reverseTransform($frenchdate)
    {
        // frenchdate = 08/02/2021;

    if ($frenchdate === null){
        // Exception
        throw new TransformationFailedException(" vous devez fournir une date!");
    }

        $date= \DateTime::createFromFormat('d/m/Y', $frenchdate);

    if ($frenchdate === false){
        // Exception
        throw new TransformationFailedException(" le format de la date n'est pas le bon");
    }
        return $date;
    }
}