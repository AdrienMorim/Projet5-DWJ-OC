<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Work;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class WorkFixtures extends Fixture
{
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        
        /*
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
        }*/

        // On crée les projets avec les catégories attribués

        // 1st
        $work = new Work();

        $work->setTitle("Webagency")
                ->setSubtitle("site de l'agence web")
                ->setContent("Développeur / Intégrateur HTML5/CSS3")
                ->setLink("https://projet1.morimadrien.fr")
                ->setCreatedAt(new \DateTime());

        $src = "public/assets/images/works/portfolio-1.png";
        $imageFile = new UploadedFile(
            $src,
            'portfolio-1.png',
            'image/png',
            filesize($src),
            null,
            true
        );

        $work->setImageFile($imageFile);
        $work->setImageAlt("Couverture du site de l\'agence Web 'Webagency'");

        $html = new Category();
        $html->setName("HTML");

        $manager->persist($html);

        $work->addCategory($html);

        $manager->persist($work);

        // 2nd
        $work = new Work();

        $work->setTitle("Office du tourisme de Strasbourg")
                ->setSubtitle("site de l'office de tourisme de Strasbourg")
                ->setContent("Développeur HTML5/CSS3/Wordpress")
                ->setLink("https://projet2.morimadrien.fr")
                ->setCreatedAt(new \DateTime());

        $src = "public/assets/images/works/portfolio-2.png";
        $imageFile = new UploadedFile(
            $src,
            'portfolio-2.png',
            'image/png',
            filesize($src),
            null,
            true
        );

        $work->setImageFile($imageFile);
        $work->setImageAlt("Couverture du site de l\'office de tourisme de Strasbourg");

        $wp = new Category();
        $wp->setName("Wordpress");

        $manager->persist($wp);

        $work->addCategory($html)
             ->addCategory($wp);

        $manager->persist($work);

        // 3rd
        $work = new Work();

        $work->setTitle("Find a bike")
                ->setSubtitle("Application Web de réservation de vélo")
                ->setContent("Développeur HTML/CSS/JavaScript/jQuery.")
                ->setLink("https://projet3.morimadrien.fr")
                ->setCreatedAt(new \DateTime());

        $src = "public/assets/images/works/portfolio-3.png";
        $imageFile = new UploadedFile(
            $src,
            'portfolio-3.png',
            'image/png',
            filesize($src),
            null,
            true
        );

        $work->setImageFile($imageFile);
        $work->setImageAlt("Couverture du site de l\'Application Web de réservation de vélo");

        $js = new Category();
        $js->setName("JS/jQuery");

        $manager->persist($js);

        $work->addCategory($html)
             ->addCategory($js);

        $manager->persist($work);

        // 4th
        $work = new Work();

        $work->setTitle("Billet simple pour l'Alaska")
                ->setSubtitle("Roman / blog de Jean Forteroche")
                ->setContent("Développeur Web HTML/CSS/PHP/MySql/Bootstrap4.")
                ->setLink("https://projet4.morimadrien.fr")
                ->setCreatedAt(new \DateTime());

        $src = "public/assets/images/works/portfolio-4.png";
        $imageFile = new UploadedFile(
            $src,
            'portfolio-4.png',
            'image/png',
            filesize($src),
            null,
            true
        );

        $work->setImageFile($imageFile);
        $work->setImageAlt("Couverture du site du Roman / blog de Jean Forteroche");

        $php = new Category();
        $php->setName("PHP/MySQL");

        $manager->persist($php);

        $work->addCategory($html)
             ->addCategory($js)
             ->addCategory($php);

        $manager->persist($work);

        // 5th
        $work = new Work();

        $work->setTitle("Portofolio")
                ->setSubtitle("site CV")
                ->setContent("Développeur Web HTML/CSS/Symfony4/PHP/MySql/Bootstrap4.")
                ->setLink("https://morimadrien.fr")
                ->setCreatedAt(new \DateTime());

        $src = "public/assets/images/works/portfolio-5.png";
        $imageFile = new UploadedFile(
            $src,
            'portfolio-5.png',
            'image/png',
            filesize($src),
            null,
            true
        );

        $work->setImageFile($imageFile);
        $work->setImageAlt("Couverture du site du Roman / blog de Jean Forteroche");

        $sf = new Category();
        $sf->setName("Symfony4");

        $manager->persist($sf);

        $work->addCategory($html)
             ->addCategory($js)
             ->addCategory($php)
             ->addCategory($sf);

        $manager->persist($work);

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
