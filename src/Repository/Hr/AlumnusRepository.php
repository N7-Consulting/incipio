<?php

namespace App\Repository\Hr;

use App\Entity\Hr\Alumnus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Personne\Membre;

/**
 * 
 * */
class AlumnusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Alumnus::class);
    }

    /**
     * @return array
     */
    public function findAllByAlumni($em)
    {
        $membres = $em->getRepository(Membre::class)->findAll();

        $alumni = [];

        foreach ($membres as $membre) {
            if ($membre->getAlumnus()) {
                $alumni[] = $membre->getAlumnus();
            } 
        }       
        return $alumni;
    }
}
