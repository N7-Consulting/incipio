<?php

namespace App\Repository\Hr;

use App\Entity\Hr\AlumnusContact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AlumnusContact|null find($id, $lockMode = null, $lockVersion = null)
 * @method AlumnusContact|null findOneBy(array $criteria, array $orderBy = null)
 * @method AlumnusContact[]    findAll()
 * @method AlumnusContact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AlumnusContactRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AlumnusContact::class);
    }

    // /**
    //  * @return AlumnusContact[] Returns an array of AlumnusContact objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AlumnusContact
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
