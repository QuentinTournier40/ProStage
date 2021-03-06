<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Stage;
use App\Entity\Entreprise;
use App\Entity\Formation;
use App\Repository\StageRepository;
use App\Repository\FormationRepository;
use App\Repository\EntrepriseRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\EntrepriseType;
use App\Form\StageType;

class ProStageController extends AbstractController
{
    /**
     * @Route("/", name="pro_stage_accueil")
     */
    public function index(StageRepository $repositoryStage): Response
    {
        return $this->render('pro_stage/accueil.html.twig', [
            
        ]);
    }

    /**
     * @Route("/tout-les-stages", name="pro_stage_liste_tout_les_stages")
     */
    public function listeToutLesStages(StageRepository $repositoryStage): Response
    {
        //Récupérer les ressources enregistrées en BD
        $stages = $repositoryStage->recupererToutLesStagesAvecFormationsEtEntreprises();
        //Envoyer les ressources récupérées à la vue  chargée de les afficher
        return $this->render('pro_stage/listeToutLesStages.html.twig', [
            'stages' => $stages,
        ]);
    }

    /**
     * @Route("/entreprises", name="pro_stage_liste_entreprises")
     */
    public function listeEntreprises(EntrepriseRepository $repositoryEntreprise): Response
    {
        //Récupérer les ressources enregistrées en BD
        $entreprises = $repositoryEntreprise->findAll();
        //Envoyer les ressources récupérées à la vue  chargée de les afficher
        return $this->render('pro_stage/listeEntreprises.html.twig', [
            'entreprises' => $entreprises,
        ]);
    }

    /**
     * @Route("/entreprise/{nom}", name="pro_stage_stage_par_entreprise")
     */
    public function stageParEntreprise(StageRepository $repositoryStage, $nom): Response
    {
        $stages = $repositoryStage->recupererStageAvecEntreprise($nom);

        return $this->render('pro_stage/stageParEntreprise.html.twig', [
            'stages' => $stages,
            'nomEntreprise' => $nom
        ]);
    }
    
    /**
     * @Route("/entreprise/{id}", name="pro_stage_stage_par_entreprise")
     */
    /*
    public function stageParEntreprise(Entreprise $entreprise): Response
    {
        

        return $this->render('pro_stage/stageParEntreprise.html.twig', [
            'entreprise' => $entreprise,
        ]);
    }*/

    /**
     * @Route("/formations", name="pro_stage_liste_formations")
     */
    public function listeFormations(FormationRepository $repositoryFormation): Response
    {
        //Récupérer les ressources enregistrées en BD
        $formations = $repositoryFormation->findAll();
        //Envoyer les ressources récupérées à la vue  chargée de les afficher
        return $this->render('pro_stage/listeFormations.html.twig', [
            'formations' => $formations,
        ]);
    }

    /**
     * @Route("/formation/{nom}", name="pro_stage_stage_par_formation")
     */
    public function stageParFormation(StageRepository $repositoryStage, $nom): Response
    {
        $stages = $repositoryStage->recupererStageAvecFormation($nom);

        return $this->render('pro_stage/stageParFormation.html.twig', [
            'stages' => $stages,
            'nomFormation' => $nom
        ]);
    }

    /**
     * @Route("/formation/{id}", name="pro_stage_stage_par_formation")
     */
    /*
    public function stageParFormation(Formation $formation): Response
    {
        return $this->render('pro_stage/stageParFormation.html.twig', [
            'formation' => $formation,
        ]);
    }*/

    /**
     * @Route("/stage/{slug}", name="pro_stage_detail_stage")
     */
    public function detailStage(StageRepository $repositoryStage, $slug): Response
    {
        $stage = $repositoryStage->recupererStageViaSlug($slug);
        return $this->render('pro_stage/detailStage.html.twig', [
            'stage' => $stage,
        ]);
    }

    /**
     * @Route("/ajouter/entreprise", name="pro_stage_creation_entreprise")
     */
    public function creationNouvelleEntreprise(Request $requeteHttp, EntityManagerInterface $manager): Response
    {
        $entreprise = new Entreprise();

        $formulaireEntreprise = $this->createForm(EntrepriseType::class, $entreprise);

        $formulaireEntreprise->handleRequest($requeteHttp);

        if($formulaireEntreprise->isSubmitted() && $formulaireEntreprise->isValid()){
            $manager->persist($entreprise);
            $manager->flush();

            return $this->redirectToRoute('pro_stage_liste_entreprises');
        }
        
        return $this->render('pro_stage/ajouterEntreprise.html.twig', [
            'vueFormulaireEntreprise' => $formulaireEntreprise -> createView(),
        ]);
    }
    
    /**
     * @Route("/modifier/entreprise/{nom}", name="pro_stage_modifier_entreprise")
     */
    public function modifierEntreprise(Request $requeteHttp, EntityManagerInterface $manager, EntrepriseRepository $repositoryEntreprise, $nom): Response
    {
        $entreprise = $repositoryEntreprise->recupererEntrepriseAvecNom($nom);

        $formulaireEntreprise = $this->createForm(EntrepriseType::class, $entreprise);

        $formulaireEntreprise->handleRequest($requeteHttp);

        if($formulaireEntreprise->isSubmitted() && $formulaireEntreprise->isValid()){
            $manager->persist($entreprise);
            $manager->flush();

            return $this->redirectToRoute('pro_stage_liste_entreprises');
        }
        
        return $this->render('pro_stage/modifierEntreprise.html.twig', [
            'vueFormulaireEntreprise' => $formulaireEntreprise -> createView(),
            'entreprise' => $entreprise,
        ]);
    }

    /**
     * @Route("/ajouter/stage", name="pro_stage_ajouter_stage")
     */
    public function ajouterUnStage(Request $requeteHttp, EntityManagerInterface $manager, StageRepository $repositoryStage): Response
    {
        $stage = new Stage();

        $formulaireStage = $this->createForm(StageType::class, $stage);

        $formulaireStage->handleRequest($requeteHttp);

        if($formulaireStage->isSubmitted() && $formulaireStage->isValid()){
            $manager->persist($stage);
            $manager->persist($stage->getEntreprise());
            $manager->flush();

            return $this->redirectToRoute('pro_stage_accueil');
        }
        
        return $this->render('pro_stage/ajouterStage.html.twig', [
            'vueFormulaireStage' => $formulaireStage -> createView(),
        ]);
    }
}
