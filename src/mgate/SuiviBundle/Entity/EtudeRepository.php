<?php
        
/*
This file is part of Incipio.

Incipio is an enterprise resource planning for Junior Enterprise
Copyright (C) 2012-2014 Florian Lefevre.

Incipio is free software: you can redistribute it and/or modify
it under the terms of the GNU Affero General Public License as
published by the Free Software Foundation, either version 3 of the
License, or (at your option) any later version.

Incipio is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License
along with Incipio as the file LICENSE.  If not, see <http://www.gnu.org/licenses/>.
*/


namespace mgate\SuiviBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * EtudeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EtudeRepository extends EntityRepository
{
    public function findByNumero($numero)
    {
        $mandat = (int) ($numero / 100);
        $num = $numero % 100;

        $qb = $this->_em->createQueryBuilder();
        $query = $qb->select('e')
                    ->from('mgateSuiviBundle:Etude', 'e')
                    ->where("e.mandat = $mandat")
                    ->andWhere("e.num = $num");
                   
        return $query->getQuery()->getOneOrNullResult();
    }
    
    
    public function getEtudesCa()
    {
        
        $qb = $this->_em->createQueryBuilder();
        

            $query = $qb->select('e')
                        ->from('mgateSuiviBundle:Cc', 'cc')
                        ->leftJoin('cc.etude', 'e');
                        //->addSelect('e')
                        //->where('e.cc IS NOT NULL')
                        //->addOrderBy('cc.dateSignature');
  
           
                  
                    
        return $query->getQuery()->getResult();;
    }
    
    
}
