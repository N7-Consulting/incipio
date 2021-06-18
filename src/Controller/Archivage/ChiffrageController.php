<?php

namespace App\Controller\Archivage;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Publish\Document;

class ChiffrageController extends AbstractController
{
    /**
     * @Route(path="archivage/chiffrage", name="archivage_chiffrage_index")
     */
    public function index(): Response
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository(Document::class)->findAll();
        $totalSize = 0;
        foreach ($entities as $entity) {
            $totalSize += $entity->getSize();
        }
        return $this->render('Archivage/Chiffrage/index.html.twig', [
            'controller_name' => 'ChiffrageController',
            'docs' => $entities,
            'totalSize' => $totalSize,
        ]);
    }
}
