<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Work;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class WorkFixtures extends Fixture
{
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        // Créer entre 1 à 5 catégories
        for($i = 1; $i <= mt_rand(1, 5); $i++){
            $category = new Category();
            $category->setName($faker->word());

            $manager->persist($category);

            // Créer entre 1 à 3 projets
            for($j = 1; $j <= mt_rand(1, 3); $j++){
                $work = new Work();
                $work->setTitle($faker->word())
                    ->setSubtitle($faker->sentence(3))
                    ->setContent($faker->paragraph())
                    ->setLink($faker->url())
                    ->setCreatedAt($faker->dateTimeBetween('- 6 month'))
                    ->setUpdatedAt($faker->dateTime())
                    ->addCategory($category);

                $manager->persist($work);
            }
        }

        // On crée un admin pour l'accès au dashboard
        $user = new User();
        $user->setUsername('usertest')
             ->setEmail('user@test.fr');

        $hash = $this->encoder->encodePassword($user, 'password');
        $user->setPassword($hash)
             ->setRoles(['ROLE_ADMIN']);

        $manager->persist($user);

        $manager->flush();
    }
}
