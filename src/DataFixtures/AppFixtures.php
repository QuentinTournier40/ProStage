<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Entreprise;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        $entreprise = new Entreprise();
        $entreprise->setNom("Safran");
        $entreprise->setAdresse($faker->realText($maxNbChars = 40, $indexSize = 2));
        $entreprise->setActivite("aeronautique");
        $entreprise->setLienSite("safran.com");
        //$entreprise->addStage();

        $manager->persist($entreprise);
        $manager->flush();
    }
}
