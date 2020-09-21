<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Comment;
use App\Entity\Category;
use App\Entity\Etablissement;
use App\Entity\Event;
use App\Entity\EventUserPro;
use App\Entity\UserProDetails;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    protected $encoder;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoderInterface)
    {
        $this->encoder = $userPasswordEncoderInterface;
    }




    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');
        $faker->addProvider(new \Bluemmb\Faker\PicsumPhotosProvider($faker));



        $titles = ['Restaurant', 'Bar', 'Musée'];

        $categories = [];

        foreach ($titles as $title) {
            $cat = new Category;
            $cat->setName(($title));

            $categories[] = $cat;

            $manager->persist($cat);
        }



        // CREATION DES USERS

        $users = [];
        $events = [];

        for ($u = 0; $u < 15; $u++) {

            $user = new User;
            $user->setEmail("user$u@gmail.com");
            // TODO FAIRE LE LISTENER QUI VAS ENCODER !!!!!!!!!!!!!!!!!!!!!!
            $user->setPassword('password');



            if ($faker->boolean(30)) {
                $user->setRoles(['ROLE_PRO']);

                $etablissement = new Etablissement;
                $etablissement->setAdress($faker->address)
                    ->setName($faker->company)
                    ->setCoverImage($faker->imageUrl(800, 800, true))
                    ->setDescription($faker->paragraphs(5, true))
                    ->setLat($faker->randomFloat())
                    ->setLng($faker->randomFloat())
                    ->setCategory($faker->randomElement($categories));

                $user->setEtablissement($etablissement);
                $manager->persist($etablissement);

                for ($e = 0; $e < mt_rand(1, 5); $e++) {
                    $event = new Event;

                    $event
                        ->setName($faker->sentence)
                        ->setDescription($faker->paragraphs(5, true))
                        ->setCoverImage($faker->imageUrl(600, 600, true))
                        ->setStartEvent($faker->dateTimeBetween($startDate = '-30 days', $endDate = 'yesterday', $timezone = null))
                        ->setEndEvent($faker->dateTimeBetween($startDate = 'now', $endDate = '+30 days', $timezone = null))
                        ->setEtablissement($etablissement);

                    $events[] = $event;

                    $manager->persist($event);
                }
            }

            $users[] = $user;

            $manager->persist($user);
        }

        for ($c = 0; $c < 40; $c++) {
            $comment = new Comment;



            $comment
                ->setComment($faker->paragraphs(2, true))
                ->setEvent($faker->randomElement($events))
                ->setUser($faker->randomElement($users));


            $manager->persist($comment);
        }

        $manager->flush();
    }
}
