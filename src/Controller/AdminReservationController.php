<?php

namespace App\Controller;

use App\Entity\Booking1;
use App\Form\AdminBooking1Type;
use App\Repository\Booking1Repository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminReservationController extends AbstractController
{
    /**
     * permet d'afficher la liste de reservations
     */
    /**
     * @Route("/admin/reservation", name="admin_reservation")
     */
    public function index(Booking1Repository $repo): Response
    {
        $booking1S= $repo->findAll();
        return $this->render('admin/reservation/index.html.twig', [
            'booking1s'=>$booking1S
        ]);
    }
    /**
     * permet d'afficher le form d'edition d'une reservation
     */
    /**
    * @Route("/admin/reservation/{id}/edit", name="admin_reservation_edit")
    /**
     * @param Booking1 $booking1
     */
    public function edit(Booking1 $booking1, Request $request ,EntityManagerInterface $manager)
    {
        $form= $this->createForm(AdminBooking1Type::class ,$booking1, ['validation_groups'=> []]);

        $form->handleRequest($request);
        if ($form->isSubmitted()&& $form->isValid()){

            // on definit le montant est vide et 0 fait partir empty.
           // on peut aussi utiliser cette methode $booking1->setAmount($booking1->getAd()->getPrice()*($booking1->getDuration());
            $booking1->setAmount(0);
            $manager->flush();

            $this->addFlash('success',"votre reservation à été modifiée");

            return $this->redirectToRoute('admin_reservation');
        }


    return  $this->render('admin/reservation/edit.html.twig', [
        'booking1'=>$booking1,
        'form'=> $form->createView()

        ]);
    }
    /**
     * cette fonction permet de supprimer la reservation
     */
    /**
     * @Route("/admin/reservation/{id}delete", name="admin_reservation_delete")
     * @param Booking1 $booking1
     * @param EntityManagerInterface $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Booking1 $booking1, EntityManagerInterface $manager){

        $manager->remove($booking1);
        $manager->flush();

        $this->addFlash('success' ,"votre reservation à été supprimée");

        return $this->redirectToRoute('admin_reservation');
    }
}
