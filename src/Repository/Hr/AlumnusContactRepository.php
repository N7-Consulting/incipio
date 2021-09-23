<?php

namespace App\Repository\Hr;

use App\Entity\Hr\Alumnus;
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

    /**
     * @return array
     */
    public function findAll()
    {
        $qb = $this->_em->createQueryBuilder();
        $query = $qb->select('c')->from(Alumnus::class, 'c')
            ->innerJoin('c.alumnusContact', 'mi')
            ->orderBy('mi.date', 'asc');

        return $query->getQuery()->getResult();
    }
}
