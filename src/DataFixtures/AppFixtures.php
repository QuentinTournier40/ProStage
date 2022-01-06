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

        $dutMPh = new Formation();
        $dutMPh->setTitre("DUT Mesures physiques");

        $tableauTypesFormations = array($dutInfo, $lpProg, $lpMetierNum, $dutMPh);

        foreach ($tableauTypesFormations as $typeFormation){
            $manager->persist($typeFormation);
        }

        // Création des entreprises et de ses stages

        for($i = 0; $i < 15 ; $i++){ 

            //Création de l'entreprise
            $entreprise = new Entreprise();
            $entreprise->setNom($faker->company);
            $entreprise->setAdresse($faker->address);
            $entreprise->setActivite($faker->word);
            $entreprise->setLienSite($faker->domainName);

            for($j = 0; $j < 3; $j++){
                $stage = new Stage();
                $stage->setTitre($faker->realText($maxNbChars = 35, $indexSize = 2));
                $stage->setMission($faker->realText($maxNbChars = 90, $indexSize = 2));
                $stage->setEmail($faker->companyEmail);
                $stage->setEntreprise($entreprise);
                $nbFormations = $faker->numberBetween($min = 1, $max = 3);
                for($k = 0; $k < $nbFormations; $k++){
                    $formationAChoisir = $faker->numberBetween($min = 0, $max = 3);
                    $stage->addTypeFormation($tableauTypesFormations[$formationAChoisir]);
                }
                $faker->unique($reset = true);
                $manager->persist($stage);
            }

            $manager->persist($entreprise);
        }
        $manager->flush();
    }
}
