<?php

namespace App\Repository\Hr;

use App\Entity\Hr\Alumnus;
use App\Entity\Personne\Membre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class AlumnusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Alumnus::class);
    }

    /**
     * @return array
     */
    public function findAllByAlumni()
    {
        $qb = $this->_em->createQueryBuilder();
        $query = $qb->select('m')->from(Membre::class, 'm')
            ->innerJoin('m.alumnus', 'mi')
            ->where('mi.lienLinkedIn IS NOT NULL')
            ->orWhere('mi.secteurActuel IS NOT NULL')
            ->orWhere('mi.posteActuel IS NOT NULL')
            ->orWhere('mi.commentaire IS NOT NULL')
            ;

        return $query->getQuery()->getResult();
    }
}
