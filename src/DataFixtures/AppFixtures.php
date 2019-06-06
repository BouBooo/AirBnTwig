<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use Faker\Factory;
use App\Entity\Image;
use Cocur\Slugify\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('FR-fr');

        for($i = 0; $i < 30; $i++) {
            $ad = new Ad();

            $ad->setTitle($faker->sentence())
                ->setCoverImage($faker->imageUrl(1000,350))
                ->setIntroduction($faker->paragraph(2))
                ->setContent('<p>' . join('</p><p>', $faker->paragraphs(5)) . '</p>')
                ->setPrice(mt_rand(40,200))
                ->setRooms(mt_rand(1, 6));

                for($j = 0; $j <= mt_rand(3, 5); $j++) {
                    $image = new Image();

                    $image->setUrl($faker->imageUrl())
                        ->setCaption($faker->sentence())
                        ->setAd($ad);
                    
                        $manager->persist($image);
                } 

            $manager->persist($ad);
        }

        $manager->flush();

        $manager->flush();
    }
}
