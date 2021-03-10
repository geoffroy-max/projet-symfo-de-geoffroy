<?php

namespace App\Controller;

use App\Entity\Ad;
use Doctrine\ORM\EntityManagerInterface;
use mysql_xdevapi\BaseResult;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AdminAcoountController extends AbstractController
{
    /**
     * permet un admin de se connecter
     */
    /**
     * @Route("/admin/login", name="admin_account_login")
     */
    public function login(AuthenticationUtils $utils): Response
    {
        $error= $utils->getLastAuthenticationError();
        $username= $utils->getLastUsername();

        return $this->render('admin/account/login.html.twig', [
            'hasError'=>$error !== null,
            'username'=>$username,

        ]);
    }

    /**
     * permet admin de se deconnecter
     */
    /**
     *@Route("/admin/logout", name="admin_account_logout")
     */
    public function logout()
    {

    }
    /**
     * permet admin de supprimer une annonce
     */
    /**
     * @Route("/admin/ads/{id}/delete", name="admin_ads_delete")
     *
     * @param Ad $ad
     * @param EntityManagerInterface $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete( Ad $ad ,EntityManagerInterface  $manager)
    {
        if (count($ad->getBooking1s()) > 0) {
           $this->addFlash('warning',
                "vous ne pouvez pas supprimer l'annonce <strong>{$ad->getTitle()}</strong> car cette possede
    deja des reservations");
        } else {
            $manager->remove($ad);
            $manager->flush();

            $this->addFlash('success',
                "l 'annonce <strong>{$ad->getTitle()}</strong> à été bien supprimé");

        }
        return $this->redirectToRoute('admin_ads');

    }
}
