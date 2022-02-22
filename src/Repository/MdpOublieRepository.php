<?php

namespace App\Repository;

use App\Entity\MdpOublie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MdpOublie|null find($id, $lockMode = null, $lockVersion = null)
 * @method MdpOublie|null findOneBy(array $criteria, array $orderBy = null)
 * @method MdpOublie[]    findAll()
 * @method MdpOublie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MdpOublieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MdpOublie::class);
    }

    // /**
    //  * @return MdpOublie[] Returns an array of MdpOublie objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MdpOublie
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
