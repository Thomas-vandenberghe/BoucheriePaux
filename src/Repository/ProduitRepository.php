<?php

namespace App\Repository;

use App\Classe\Search;
use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Produit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produit[]    findAll()
 * @method Produit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }


    /** 
    * requete qui me permet de récupérer les produits en fonction de la recherche de l'utiliisateur
    *@return Produit[]
    */

    public function findWithSearch( Search $search)
    {
        $query = $this
        ->createQueryBuilder('p')
        ->select('c','p')
        ->join('p.categorie','c');

        if (!empty($search->categories))
        {
            $query = $query
                ->andWhere('c.id IN (:categories)')
                ->setParameter('categories', $search->categories);
        }

        if (!empty($search->string)){
            $query = $query
            ->andWhere('p.name LIKE :string')
            ->setParameter('string', "%$search->string%");

        }

        return $query->getQuery()->getResult();
    }

    public function findProduitsCommandesSemaine($nom)
    {
        return $this->createQueryBuilder('p')
        ->andWhere('p.name = :nom')
        ->setParameter('nom', $nom)
        ->orderBy('p.id', 'DESC')
        ->getQuery()
        ->getResult();
    }


    // /**
    //  * @return Produit[] Returns an array of Produit objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Produit
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
