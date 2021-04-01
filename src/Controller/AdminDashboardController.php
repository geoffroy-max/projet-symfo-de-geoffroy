<?php

namespace App\Controller;

use App\Service\StatsService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminDashboardController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_dashboard")
     */
    public function index(EntityManagerInterface $manager ,StatsService $statsService): Response
    {
        $stats= $statsService->getStats();
        $bestAds= $statsService->getbestAds();
        $worstAds= $statsService->getWorstAds();

        //$users = $statsService->getUsersCount();
      //$ads   = $statsService->getAdsCount();
    //$bookings = $statsService->getBookingsCount();
    //$comments= $statsService->getCommentsCount();


       // $users= $manager->createQuery('SELECT COUNT(u) FROM App\Entity\User u')->getSingleScalarResult();

        //$ads= $manager->createQuery('SELECT COUNT(a) FROM App\Entity\Ad a ')->getSingleScalarResult();
        //$bookings= $manager->createQuery('SELECT COUNT(b) FROM App\Entity\Booking1 b ')->getSingleScalarResult();
        //$comments= $manager->createQuery('SELECT COUNT(c) FROM App\Entity\Comment c ')->getSingleScalarResult();

        //$bestAds= $manager->createQuery('SELECT AVG(c.rating)as note, a.title, a.id, u.firstName, u.lastName, u.picture
               // FROM App\Entity\Comment c
               //// JOIN c.ad a
               // JOIN a.Author u
               // GROUP BY a
                //ORDER BY note DESC
                //')->setMaxResults(5)->getResult();




        return $this->render('admin/dashboard/index.html.twig', [
            'stats'=>$stats,
               // 'users'=>$users,
                //'ads'=>$ads,
               //'bookings'=>$bookings,
                //'comments'=>$comments,

        'bestAds'=>$bestAds,
            'worstAds'=>$worstAds


        ]);
    }
}
