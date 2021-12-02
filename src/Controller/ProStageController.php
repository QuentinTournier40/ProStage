<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProStageController extends AbstractController
{
    /**
     * @Route("/", name="pro_stage_accueil")
     */
    public function index(): Response
    {
        return $this->render('pro_stage/index.html.twig', [
            'controller_name' => 'Bienvenue sur la page d\'accueil de Prostages',
        ]);
    }

    /**
     * @Route("/entreprises", name="pro_stage_entreprises")
     */
    public function entreprises(): Response
    {
        return $this->render('pro_stage/entreprises.html.twig', [
            //'controller_name' => 'Cette page affichera la liste des entreprises proposant un stage',
        ]);
    }

    /**
     * @Route("/formations", name="pro_stage_formations")
     */
    public function formations(): Response
    {
        return $this->render('pro_stage/formations.html.twig', [
            //'controller_name' => 'Cette page affichera la liste des formations de l\'IUT',
        ]);
    }

    /**
     * @Route("/stages/{id}", name="pro_stage_stage_id")
     */
    public function stages($id): Response
    {
        return $this->render('pro_stage/stages.html.twig', [
            'id' => $id,
            //'controller_name' => 'Cette page affichera le descriptif du stage ayant pour identifiant ',
        ]);
    }
    
}
