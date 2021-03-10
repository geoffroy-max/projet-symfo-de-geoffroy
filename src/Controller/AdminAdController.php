<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Form\AdType;
use App\Repository\AdRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminAdController extends AbstractController
{
    /**
     * permet aux admin de gerer des annonces du site
     */
    /**
     * @Route("/admin/ads", name="admin_ads")
     */
    public function index(AdRepository $repo): Response
    {

        return $this->render('admin/ad/index.html.twig', [
            'ads' => $repo->findAll()
        ]);
    }
    /**
     * permet d'afficher le form d'edition
     *
     */
    /**
     * @Route("/admin/ads/{id}/edit", name="admin_ads_edit")
     */

    public function edit(Ad $ad ,Request $request, EntityManagerInterface $manager){


$form= $this->createForm(AdType::class, $ad);
$form->handleRequest($request);
if ($form->isSubmitted()&& $form->isValid()){
    $manager->persist($ad);
    $manager->flush();
    $this->addFlash('success',
        "l'annonce <strong>{$ad->getTitle()}</strong> a bien été enregistrée");

}

return $this->render('admin/ad/edit.html.twig',[

    'ad'=> $ad,
    'form'=> $form->createView()
]);
    }
}
