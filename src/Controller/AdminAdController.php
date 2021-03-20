<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Form\AdType;
use App\Repository\AdRepository;

use App\Service\PaginationService;
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
     * @Route("/admin/ads/{page<\d+>?1}", name="admin_ads")
     */
    public function index(AdRepository $repo, $page, PaginationService $pagination): Response
    {      $pagination->setEntityClass(Ad::class)
                       ->setPage($page);
    // on n est plus obligé de definir la route dans le controler parceque requeststack ns permet de recuperer la route actuelle
                        //->setroute("admin_ads");

        // pour claculer ordre du debut de pagination
        //1*10=10-10=0=> pagination commence à partir d l elmnt 0
        // 2*10=20-10=10 => pagination commence à partir d l elmnt 10
        //$start= $page*$limit - $limit;

        //$ads= $repo->findBy([],[],$limit,$start);
        // $total recuperer ttes les données de bd

        //$total= count($repo->findAll());
        // divisant le total par limit pour avoir le nbre de pagination:ex total =100 et lmt=10 on ora 10 p de pagination

        //$pages=  ceil($total / $limit);

        return $this->render('admin/ad/index.html.twig', [
            'pagination'=>$pagination
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
