<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Work;

class WorkFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i = 1; $i <= 10; $i++){
            $work = new Work();
            $work->setTitle("Titre $i")
                 ->setSubtitle("Sous-titre $i")
                 ->setContent("Contenu de $i")
                 ->setLink("Lien $i")
                 ->setImage("http://via.placeholder.com/640x360")
                 ->setImageAlt("Description de $i")
                 ->setCreatedAt(new \DateTime());
            $manager->persist($work);
        }

        $manager->flush();
    }
}
