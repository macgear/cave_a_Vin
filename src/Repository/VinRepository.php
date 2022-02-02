<?php

namespace App\Repository;

use App\Entity\Vin;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\Query\Expr\Select;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Vin|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vin|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vin[]    findAll()
 * @method Vin[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VinRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vin::class);
    }

    // Permet d'afficher les stocks sous forme de variable
    public function stock(): array
    {
        $stocks = [];
        $stocks['total'] = $this->nbrVinEnCave();
        $stocks['blanc'] = $this->nbrVinEnCaveByRobe('blanc');
        $stocks['rouge'] = $this->nbrVinEnCaveByRobe('rouge');
        $stocks['rose'] = $this->nbrVinEnCaveByRobe('rose');
        return $stocks;
    }


    public function nbrVinEnCave(): int
    {
        $stock = $this->createQueryBuilder('v')
            ->Select('SUM(v.qtt_stock) as nbr')
            ->getQuery()
            ->getSingleScalarResult()
            ;
           //dd($stock);
            return $stock;
    }


    public function nbrVinEnCaveByRobe($robe): ?int
    {
 
         $stock = $this->createQueryBuilder('v')
            ->Select('SUM(v.qtt_stock) as nbr')
            ->where('v.robe = :robe')
            ->setParameter('robe', $robe)
            ->getQuery()
            ->getSingleScalarResult()
            ;
            // ne marche que pour une affectation
            //opérateur ternaire
         $stock = ($stock == null)? 0 : $stock;
            //dd($stock);
            return $stock;
    } 




    // /**
    //  * @return Vin[] Returns an array of Vin objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Vin
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
