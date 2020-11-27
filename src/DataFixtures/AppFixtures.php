<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use App\Entity\Image;
use Cocur\Slugify\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
$faker= Factory::create('fr_FR');

        for($i=1; $i<=30; $i++) {
            $ad = new Ad();

            $title = $faker->sentence();

            $introduction = $faker->paragraph(2);
            $coverImage = $faker->imageUrl(1000 ,350);
            $content= $content= '<p>'.join($faker->paragraphs(5),'</p><p>'). '</p>';


            $ad->setTitle($title)

                ->setIntroduction($introduction)
                ->setContent($content)
                ->setCoverImage($coverImage)
                ->setPrice(mt_rand(40, 200))
                ->setRooms(mt_rand(1, 5));

            for($j=1; $j<= mt_rand(2 ,5);$j++)
            {   $image= new Image();

                $image->setUrl($faker->imageUrl())
                    ->setLegende($faker->sentence())
                    ->setAd($ad);
$manager->persist($image);

            }

            $manager->persist($ad);
        }
        $manager->flush();
    }
}
