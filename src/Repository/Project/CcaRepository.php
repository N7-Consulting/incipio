<?php

namespace App\Repository\Project;

use Doctrine\ORM\EntityRepository;

class CcaRepository extends EntityRepository
{
  public function findAll()
  {
    return $this->findBy([], ['dateFin' => 'DESC']);
  }
}
