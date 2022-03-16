<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Entreprise;
use App\Entity\Stage;
use App\Entity\Formation;
use App\Entity\User;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        //Création des utilisateurs
        $admin = new User();
        $admin->setEmail("admin@admin.fr");
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword('$2y$10$M9LGJbNp.sHWBCOZkJF0P.yZpArUJTp4aGkYCkcYLpRIdSjJzYvBa');
        $manager->persist($admin);

        $normal = new User();
        $normal->setEmail("normal@normal.fr");
        $normal->setRoles(['ROLE_USER']);
        $normal->setPassword('$2y$10$m2RFtA7bbpq8wWrjvcQGjunai7ZgvPV288YoNnZ3BYA8hhFFlKQES');
        $manager->persist($normal);

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
        $nombreEntreprise = $faker->numberBetween(15, 20);
        for($i = 0; $i < $nombreEntreprise ; $i++){ 

            //Création de l'entreprise
            $entreprise = new Entreprise();
            $entreprise->setNom($faker->company);
            $entreprise->setAdresse($faker->address);
            $entreprise->setActivite($faker->companySuffix);
            $entreprise->setLienSite($faker->domainName);
            
            $nombreStagePourEntreprise = $faker->numberBetween(1, 3);
            for($j = 0; $j < $nombreStagePourEntreprise; $j++){
                $stage = new Stage();
                $stage->setTitre($faker->realText(35, 2));
                $stage->setMission($faker->realText(90, 2));
                $stage->setEmail($faker->companyEmail);
                $stage->setEntreprise($entreprise);
                $nbFormations = $faker->numberBetween(1, 3);
                for($k = 0; $k < $nbFormations; $k++){
                    $formationAChoisir = $faker->unique()->numberBetween(0, 3);
                    $stage->addTypeFormation($tableauTypesFormations[$formationAChoisir]);
                }
                $faker->unique(true);
                $manager->persist($stage);
            }

            $manager->persist($entreprise);
        }
        $manager->flush();
    }
}
