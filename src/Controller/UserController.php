<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * permet d'afficher le nom de l utilisateur
     */
    /**
     * @Route("/user/{slug}", name="user_show")
     */
    public function index1(User $user): Response
    {
        return $this->render('user/index1.html.twig', [
            'user' => $user,
        ]);
    }
}
