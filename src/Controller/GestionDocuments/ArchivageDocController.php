<?php

namespace App\Controller\GestionDocuments;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Publish\Document;
use App\Entity\Treso\Facture;
  

class ArchivageDocController extends AbstractController
{
    /**
     * @Route("archivage/doc", name="archivage_doc")
     */
    public function index(): Response
    {   $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository(Document::class)->findAll();
        $factures = $em->getRepository(Facture::class)->getFactures();
        $totalSize = 0;
        foreach ($entities as $entity) {
            $totalSize += $entity->getSize();
        }
        return $this->render('GestionDocuments/archivage_doc/index.html.twig', [
            'controller_name' => 'ArchivageDocController',
            'docs' => $entities,
            'totalSize' => $totalSize,
            'factures' => $factures,
        ]);
    }
}
