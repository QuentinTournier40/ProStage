<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Stage;
use App\Entity\Entreprise;
use App\Entity\Formation;

class ProStageController extends AbstractController
{
    /**
     * @Route("/", name="pro_stage_accueil")
     */
    public function index(): Response
    {
        //Récupérer le repository de l'entité Stage
        $repositoryStage = $this->getDoctrine()->getRepository(Stage::class);
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
    public function entreprises(): Response
    {
        //Récupérer le repository de l'entité Stage
        $repositoryEntreprise = $this->getDoctrine()->getRepository(Entreprise::class);
        //Récupérer les ressources enregistrées en BD
        $entreprises = $repositoryEntreprise->findAll();
        //Envoyer les ressources récupérées à la vue  chargée de les afficher
        return $this->render('pro_stage/entreprises.html.twig', [
            'entreprises' => $entreprises,
        ]);
    }

    /**
     * @Route("/entreprise/{id}", name="pro_stage_entreprises_id")
     */
    public function entreprise($id): Response
    {
        return $this->render('pro_stage/entreprise.html.twig', [
            'id' => $id,
        ]);
    }

    /**
     * @Route("/formations", name="pro_stage_formations")
     */
    public function formations(): Response
    {
        //Récupérer le repository de l'entité Formation
        $repositoryFormation = $this->getDoctrine()->getRepository(Formation::class);
        //Récupérer les ressources enregistrées en BD
        $formations = $repositoryFormation->findAll();
        //Envoyer les ressources récupérées à la vue  chargée de les afficher
        return $this->render('pro_stage/formations.html.twig', [
            'formations' => $formations,
        ]);
    }

    /**
     * @Route("/formation/{id}", name="pro_stage_formations")
     */
    public function formation($id): Response
    {
        return $this->render('pro_stage/formation.html.twig', [
            'id' => $id,
        ]);
    }



    /**
     * @Route("/stage/{id}", name="pro_stage_stage_id")
     */
    public function stage($id): Response
    {
        return $this->render('pro_stage/stage.html.twig', [
            'id' => $id,
        ]);
    }
    
}
