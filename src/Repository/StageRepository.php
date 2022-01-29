<?php

namespace App\Repository;

use App\Entity\Stage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Stage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stage[]    findAll()
 * @method Stage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stage::class);
    }

    // /**
    //  * @return Stage[] Returns an array of Stage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Stage
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function recupererStageAvecEntreprise($nomEntreprise)
    {
        return $this->createQueryBuilder('s')
                    ->select('s, e')
                    ->join('s.entreprise', 'e')
                    ->where('e.nom = :unNomEntreprise')
                    ->setParameter('unNomEntreprise', $nomEntreprise)
                    ->getQuery()
                    ->getResult();
    }

    public function recupererStageAvecFormation($nomFormation)
    {
        $gestionnaireEntite = $this->getEntityManager();
        $requete = $gestionnaireEntite->createQuery('SELECT s,tf,e FROM App\Entity\Stage s JOIN s.typeFormation tf JOIN s.entreprise e');
        return $requete->execute();
    }

    public function recupererToutLesStagesAvecFormationsEtEntreprises()
    {
        return $this->createQueryBuilder('s')
                    ->select('s, e, tf')
                    ->join('s.entreprise', 'e')
                    ->join('s.typeFormation', 'tf')
                    ->getQuery()
                    ->getResult();
    }

    public function recupererInformationsStage($idStage)
    {
        return $this->createQueryBuilder('s')
                    ->select('s, e, tf')
                    ->join('s.entreprise', 'e')
                    ->join('s.typeFormation', 'tf')
                    ->where('s.id = :idStage')
                    ->setParameter('idStage', $idStage)
                    ->getQuery()
                    ->getResult();
    }
}
