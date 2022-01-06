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

class ProStageController extends AbstractController
{
    /**
     * @Route("/", name="pro_stage_accueil")
     */
    public function index(StageRepository $repositoryStage): Response
    {
        //Récupérer les ressources enregistrées en BD
        $stages = $repositoryStage->findAll();
        //Envoyer les ressources récupérées à la vue  chargée de les afficher
        return $this->render('pro_stage/index.html.twig', [
            'stages' => $stages,
        ]);
    }

    /**
     * @Route("/entreprises", name="pro_stage_entreprises")
     */
    public function entreprises(EntrepriseRepository $repositoryEntreprise): Response
    {
        //Récupérer les ressources enregistrées en BD
        $entreprises = $repositoryEntreprise->findAll();
        //Envoyer les ressources récupérées à la vue  chargée de les afficher
        return $this->render('pro_stage/entreprises.html.twig', [
            'entreprises' => $entreprises,
        ]);
    }

    /**
     * @Route("/entreprise/{id}", name="pro_stage_entreprise_id")
     */
    public function entreprise(Entreprise $entreprise): Response
    {
        return $this->render('pro_stage/entreprise.html.twig', [
            'entreprise' => $entreprise,
        ]);
    }

    /**
     * @Route("/formations", name="pro_stage_formations")
     */
    public function formations(FormationRepository $repositoryFormation): Response
    {
        //Récupérer les ressources enregistrées en BD
        $formations = $repositoryFormation->findAll();
        //Envoyer les ressources récupérées à la vue  chargée de les afficher
        return $this->render('pro_stage/formations.html.twig', [
            'formations' => $formations,
        ]);
    }

    /**
     * @Route("/formation/{id}", name="pro_stage_formation_id")
     */
    public function formation($id): Response
    {
        //Récupérer le repository de l'entité Formation 
        $repositoryFormation = $this->getDoctrine()->getRepository(Formation::class);
        //Récupérer la ressources enregistrée en BD qui possede l'id ayant pour valeur $id
        $formation = $repositoryFormation->find($id);
        return $this->render('pro_stage/formation.html.twig', [
            'formation' => $formation,
        ]);
    }



    /**
     * @Route("/stage/{id}", name="pro_stage_stage_id")
     */
    public function stage(Stage $stage): Response
    {
        return $this->render('pro_stage/stage.html.twig', [
            'stage' => $stage,
        ]);
    }
    
}
