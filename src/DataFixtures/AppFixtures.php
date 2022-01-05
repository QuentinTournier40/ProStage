<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Entreprise;
use App\Entity\Stage;
use App\Entity\Formation;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        // Création des formations
        $dutInfo = new Formation();
        $dutInfo->setTitre("DUT Informatique");

        $lpProg = new Formation();
        $lpProg->setTitre("Licence programmation avancée");

        $lpMetierNum = new Formation();
        $lpMetierNum->setTitre("Licence des metiers du numerique");

        $dutGea = new Formation();
        $dutGea->setTitre("DUT Gestion des entreprises et des administrations");

        $tableauTypesFormations = array($dutInfo, $lpProg, $lpMetierNum, $dutGea);

        foreach ($tableauTypesFormations as $typeFormation){
            $manager->persist($typeFormation);
        }

        // Création des entreprises et de ses stages

        for($i = 0; $i < 15 ; $i++){ 

            //Création de l'entreprise
            $entreprise = new Entreprise();
            $entreprise->setNom($faker->company);
            $entreprise->setAdresse($faker->address);
            $entreprise->setActivite("aeronautique");
            $entreprise->setLienSite($faker->domainName);

            for($j = 0; $j < 3; $j++){
                $stage = new Stage();
                $stage->setTitre($faker->realText($maxNbChars = 200, $indexSize = 2));
                $stage->setMission($faker->realText($maxNbChars = 600, $indexSize = 2));
                $stage->setEmail($faker->companyEmail);
                $stage->setEntreprise($entreprise);
                $formationAChoisir = $faker->numberBetween($min = 0, $max = 3);
                $stage->addTypeFormation($tableauTypesFormations[$formationAChoisir]);

                $manager->persist($stage);
            }

            $manager->persist($entreprise);
        }
        $manager->flush();
    }
}
