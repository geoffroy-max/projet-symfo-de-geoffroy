<?php
namespace  App\Service;

use Doctrine\ORM\EntityManagerInterface;

Class StatsService
{

    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function getStats()
    {
        $users = $this->getUsersCount();
        $ads = $this->getAdsCount();
        $bookings = $this->getBookingsCount();
        $comments = $this->getCommentsCount();
        return compact('users', 'ads', 'bookings', 'comments');
    }


    public function getUsersCount()
    {
        return $this->manager->createQuery('SELECT COUNT(u) FROM App\Entity\User u')->getSingleScalarResult();
    }

    public function getAdsCount()
    {
        return $this->manager->createQuery('SELECT COUNT(a) FROM App\Entity\Ad a ')->getSingleScalarResult();
    }

    public function getBookingsCount()
    {
        return $this->manager->createQuery('SELECT COUNT(b) FROM App\Entity\Booking1 b ')->getSingleScalarResult();
    }

    public function getCommentsCount()
    {
        return $this->manager->createQuery('SELECT COUNT(c) FROM App\Entity\Comment c ')->getSingleScalarResult();
    }

    public function getbestAds()
    {
        return $this->manager->createQuery('SELECT AVG(c.rating) as note, a.title, a.id, u.firstName, u.lastName, u.picture 
                FROM App\Entity\Comment c
                JOIN c.ad a
                JOIN a.Author u
                GROUP BY a
                ORDER BY note DESC'
        )->setMaxResults(5)
            ->getResult();
    }
    public function getWorstAds()
    {
        return $this->manager->createQuery('SELECT AVG(c.rating) as note, a.title, a.id, u.firstName, u.lastName, u.picture 
                FROM App\Entity\Comment c
                JOIN c.ad a
                JOIN a.Author u
                GROUP BY a
                ORDER BY note ASC'
        )->setMaxResults(5)
            ->getResult();
    }


}