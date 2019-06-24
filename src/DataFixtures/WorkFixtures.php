<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Work;
use App\Entity\Category;

class WorkFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        // Créer entre 6 à 10 projets
        for($i = 1; $i <= mt_rand(6, 10); $i++){
            $work = new Work();
            $work->setTitle($faker->word())
                 ->setSubtitle($faker->sentence(3))
                 ->setContent($faker->paragraph())
                 ->setLink($faker->url())
                 ->setCreatedAt($faker->dateTimeBetween('- 6 month'));

            $manager->persist($work);

            // Créer entre 3 à 5 catégories
            for($j = 1; $j <= mt_rand(3, 5); $j++){
                $category = new Category();
                $category->setTitle($faker->word())
                        ->addWork($work);

                $manager->persist($category);
            }
        }
        $manager->flush();
    }
}
