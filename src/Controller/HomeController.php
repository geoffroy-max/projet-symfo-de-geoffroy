<?php

namespace App\Controller;

use App\Repository\AdRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * permet d 'afficher la page d'accueil
     */
    /**
     * @Route("/", name="blog")
     */
    public function home(AdRepository $ad ,UserRepository $userRepo): Response
    {
$query= $ad->findBestAds(3);

        return $this->render('blog/home.html.twig', [
            'ads'=>$query,
            'users'=>$userRepo->findBestUsers()
        ]);
    }
}
