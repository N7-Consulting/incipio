<?php

namespace App\Repository\Project;

use App\Entity\Project\Ce;
use Doctrine\ORM\EntityRepository;

class CeRepository extends EntityRepository
{
  public function findAllByCca($id)
  {
    $typeBdc = Ce::TYPE_BDC;

    $qb = $this->_em->createQueryBuilder();
    $qb->select('bdc')
    ->from(Ce::class, 'bdc')
    ->where('bdc IS NOT NULL')
    ->andWhere('bdc.type = :typeBdc')
    ->join('bdc.etude', 'e')
    ->andWhere('e.cca = :id')
    ->setParameter('typeBdc', $typeBdc)
    ->setParameter('id', $id)
    ->orderBy('bdc.dateSignature', 'DESC');
    $query = $qb->getQuery();

    return $query->getResult();
  }
}
