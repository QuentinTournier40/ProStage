<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Stage;

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
        return $this->render('pro_stage/entreprises.html.twig', [
        ]);
    }

    /**
     * @Route("/entreprises/{id}", name="pro_stage_entreprises_id")
     */
    public function entreprise(): Response
    {
        return $this->render('pro_stage/entreprise.html.twig', [
        ]);
    }

    /**
     * @Route("/formations", name="pro_stage_formations")
     */
    public function formations(): Response
    {
        return $this->render('pro_stage/formations.html.twig', [
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
