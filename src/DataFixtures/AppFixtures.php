<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use Faker\Factory;
use App\Entity\Role;
use App\Entity\User;
use App\Entity\Image;
use Cocur\Slugify\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    public function __construct(UserPasswordEncoderInterface $encoder) {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('FR-fr');

        $adminRole = new Role();
        $adminRole->setTitle('ROLE_ADMIN');
        $manager->persist($adminRole);

        $adminUser = new User();
        $adminUser ->setFirstname('Florent')
                    ->setLastname('NICOLAS')
                    ->setEmail('flonicolas.pro@outlook.fr') 
                    ->setHash($this->encoder->encodePassword($adminUser, 'rootroot'))
                    ->setPicture('https://pickaface.net/gallery/avatar/20121024_082235_4373_CV.png')
                    ->setIntroduction($faker->sentence())
                    ->setDescription('<p>' . join('</p><p>', $faker->paragraphs(5)) . '</p>')
                    ->addUserRole($adminRole);
        $manager->persist($adminUser);
        

        $users = [];
        $genres = ['male', 'female'];

        for($u = 0; $u <= 10; $u++) {
            $user = new User();

            $genre = $faker->randomElement($genres);

            $picture = 'https://randomuser.me/api/portraits/';
            $pictureId = $faker->numberBetween(1, 99) . '.jpg';

            if($genre == "male") {
                $picture = $picture . 'men/' . $pictureId;
            } else {
                $picture = $picture . 'women/' . $pictureId;
            }

            $hash = $this->encoder->encodePassword($user, 'password');

            $user->setFirstname($faker->firstname($genre))
                    ->setLastname($faker->lastname())
                    ->setEmail($faker->email())
                    ->setIntroduction($faker->sentence())
                    ->setDescription('<p>' . join('</p><p>', $faker->paragraphs(5)) . '</p>')
                    ->setPicture($picture)
                    ->setHash($hash);

            $manager->persist($user);
            $users[] = $user;
        }

        for($i = 0; $i < 30; $i++) {
            $ad = new Ad();

            $user = $users[mt_rand(0, count($users)-1)];
            
            $ad->setTitle($faker->sentence())
                ->setCoverImage('https://place-hold.it/300x500')
                ->setIntroduction($faker->paragraph(2))
                ->setContent('<p>' . join('</p><p>', $faker->paragraphs(5)) . '</p>')
                ->setPrice(mt_rand(40,200))
                ->setRooms(mt_rand(1, 6))
                ->setAuthor($user);

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
