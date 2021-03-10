<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use App\Entity\Booking;
use App\Entity\Booking1;
use App\Entity\Comment;
use App\Entity\Image;


use App\Entity\Role;
use App\Entity\User;
use Cocur\Slugify\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {return $this->encoder=$encoder;

    }
    public function load(ObjectManager $manager)
    {
$faker= Factory::create('fr_FR');

// créer un role d'adminstrateur

       $adminRole= new Role();
       $adminRole->setTitle('ROLE_ADMIN');
           $manager->persist($adminRole);


// créer un utilisateur qui possede ce role
           $adminUser= new User();
           $adminUser->setFirstName('geoffroy')
               ->setLastName('ndongo')
               ->setEmail('ndongogeoffroy10@yahoo.fr')
               ->setPicture('https://scontent-cdg2-1.xx.fbcdn.net/v/t1.0-9/88183228_2828237450576053_609058510403010560_n.jpg?_nc_cat=108&ccb=2&_nc_sid=e3f864&_nc_ohc=mLupm0eAKjoAX-Uh295&_nc_ht=scontent-cdg2-1.xx&oh=d446bc8a4e51dd6fbb2219897d11393d&oe=6017C976')
               ->setIntroduction($faker->sentence())
               ->setHash($this->encoder->encodePassword($adminUser, 'password'))
               ->setDescription('<p>' . join($faker->paragraphs(3), '</p><p>') . '</p>')
               ->addUserRole($adminRole);
           $manager->persist($adminUser);



// nous gérons les utilisateurs

  $users=[];
  $genres= ['male', 'female'];
for($i=1; $i<=10; $i++) {
     $user = new User();
    $genre = $faker->randomElements($genres);
    $picture = 'https://randomuser.me/api/portraits/';
    $pictureId = $faker->numberBetween(1, 99). '.jpg';

    /*if($genre== "male"){ $picture= $picture. 'men/'.$pictureId;
    else $picture= $picture.'women/'.$pictureId;
    }
*/

    $picture.= ($genre == 'male'? 'men/': 'women/').$pictureId;
    $hash= $this->encoder->encodePassword($user ,'password');

    $user->setFirstName($faker->firstname($genre))
        ->setLastName($faker->lastname)
        ->setEmail($faker->email)
        ->setIntroduction($faker->sentence)
        ->setDescription('<p>' . join($faker->paragraphs(3), '</p><p>') . '</p>')
        ->setHash($hash)
        ->setPicture($picture);
    $manager->persist($user);
    $users [] = $user;
}
// nous gérons des annonces
        for($i=1; $i<=30; $i++) {
            $ad = new Ad();


            $title = $faker->sentence();

            $introduction = $faker->paragraph(2);
            $coverImage = $faker->imageUrl(1000 ,350);
            $content= $content= '<p>'.join($faker->paragraphs(5),'</p><p>'). '</p>';
            $user= $users[mt_rand(0, count($users) -1)];


            $ad->setTitle($title)

                ->setIntroduction($introduction)
                ->setContent($content)
                ->setCoverImage($coverImage)
                ->setPrice(mt_rand(40, 200))
                ->setRooms(mt_rand(1, 5))
                ->setAuthor($user);


            for($j=1; $j<= mt_rand(2 ,5);$j++)
            {   $image= new Image();

                $image->setUrl($faker->imageUrl())
                    ->setLegende($faker->sentence())
                    ->setAd($ad);
$manager->persist($image);

            }
            // Gestion des reservations

            for($k=1; $k<= mt_rand(0,10); $k++)
            {
                $booking1= new Booking1();

                $createdAt = $faker->dateTimeBetween('-6 months');
                $startDate = $faker->dateTimeBetween('-3 months');

                // gestion de la date de fin

                $duration= mt_rand(3 ,10);
                $endDate = (clone $startDate)->modify("+$duration days");

                $amount  = $ad->getPrice()*$duration ;
                $booker  = $users[mt_rand(0 ,count($users)-1)];
                $comment =$faker->paragraph();

                $booking1->setBooker($booker)
                    ->setAd($ad)
                    ->setCreatedAt($createdAt)
                    ->setStartDate($startDate)
                    ->setEndDate($endDate)
                    ->setAmount($amount)
                    ->setComment($comment);

                $manager->persist($booking1);

                // gestion des commentaires
                // on va tirer pile ou face si ça tombe sur 0 le if ne se fera pas.on ne vx pas laiss un comm sur tte les reseravtions
                if (mt_rand(0,1)){
                    $comment = new Comment();
                    $comment->setContent($faker->paragraph)
                        ->setRating(mt_rand(1,5))
                        ->setAuthor($booker)
                        ->setAd($ad);
                    $manager->persist($comment);
                }

            }
            $manager->persist($ad);
        }
        $manager->flush();
    }
}
