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
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class ProStageController extends AbstractController
{
    /**
     * @Route("/", name="pro_stage_accueil")
     */
    public function index(StageRepository $repositoryStage): Response
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
     * @Route("/stage/{id}", name="pro_stage_detail_stage")
     */
    public function detailStage(StageRepository $repositoryStage, $id): Response
    {
        $stage = $repositoryStage->recupererInformationsStage($id);
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

        $formulaireEntreprise = $this->createFormBuilder($entreprise)
                                     ->add('nom', TextType::class)
                                     ->add('adresse', TextType::class)
                                     ->add('activite', TextareaType::class)
                                     ->add('lienSite', UrlType::class)
                                     ->add('Créer', SubmitType::class)
                                     ->getForm();

        $formulaireEntreprise->handleRequest($requeteHttp);

        if($formulaireEntreprise->isSubmitted()){
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

        $formulaireEntreprise = $this->createFormBuilder($entreprise)
                                     ->add('nom', TextType::class)
                                     ->add('adresse', TextType::class)
                                     ->add('activite', TextareaType::class)
                                     ->add('lienSite', UrlType::class)
                                     ->add('Créer', SubmitType::class)
                                     ->getForm();

        $formulaireEntreprise->handleRequest($requeteHttp);

        if($formulaireEntreprise->isSubmitted()){
            $manager->persist($entreprise);
            $manager->flush();

            return $this->redirectToRoute('pro_stage_liste_entreprises');
        }
        
        return $this->render('pro_stage/modifierEntreprise.html.twig', [
            'vueFormulaireEntreprise' => $formulaireEntreprise -> createView(),
            'entreprise' => $entreprise,
        ]);
    }
}
