<?php

/*
 * This file is part of the Incipio package.
 *
 * (c) Florian Lefevre
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace mgate\CommentBundle\Manager;

use FOS\CommentBundle\Acl\AclThreadManager as FOSthread;
use Doctrine\ORM\EntityManager;
use mgate\SuiviBundle\Entity\Etude;

class ThreadManager
{
    protected $tm;
    protected $em;

    public function __construct(FOSthread $threadManager, EntityManager $entitymanager)
    {
        $this->tm = $threadManager;
        $this->em = $entitymanager;
    }

    /**
     * @param $name
     * @param $permaLink
     * @param Etude $entity
     * Used  only in mgate\CommentBundle\Controller\DefaultController for undocumented purpose (maintenance ??)
     */
    public function creerThread($name, $permaLink, Etude $entity)
    {
        if (!$entity->getThread()) {


            $thread = $this->tm->createThread($name.$entity->getId());
            $thread->setPermalink($permaLink);//non exploité dans notre cas. Commentable.
            $entity->setThread($thread);
            //persist thread inutile, car cascade sur $entity.

            $this->em->flush();
        }
    }
}
