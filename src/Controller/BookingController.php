<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\Booking1;
use App\Form\Booking1Type;


use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookingController extends AbstractController
{
    /**
     * permet d'afficher le formulaire de la reservation
     */
    /**
     * @Route("/ads/{slug}/book", name="booking_create")
     * @IsGranted("ROLE_USER")
     */
    public function book(Ad $ad , Request $request, EntityManagerInterface $manager): Response
    {$booking1= new Booking1();

    $form= $this->createForm(Booking1Type::class, $booking1);

    $form->handleRequest($request);

    if($form->isSubmitted()&& $form->isValid())
    { $user = $this->getUser();
        $booking1->setBooker($user)
                  ->setAd($ad);

// si les dates ne sont pas disponibles, message d'erreur
        if(!$booking1->isBookableDate()){
            $this->addFlash('warning', "les dates que vous avez choisi ne peuvent pas etre reservées:elles sont deja prises" );
        }else {
            // sinon enregistrement et redirection
            $manager->persist($booking1);
            $manager->flush();

            return $this->redirectToRoute('booking1_show1', ['id' => $booking1->getId(),
                'withAlert' => true]);
        }
    }
        return $this->render('booking/book.html.twig', [
            'ad' => $ad,
            'form'=>$form->createView()
        ]);
    }
    /**
     * permet d'afficher la page de la reservation
     */
    /**
     * @Route("/booking1/{id}", name="booking1_show1")
     */
    public function show1(Booking1 $booking1)
    {
        return $this->render('booking/show1.html.twig',[
            'booking1'=>$booking1
        ]);

    }
}
