<?php

namespace App\Controller\GestionDocuments;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Publish\Document;
use App\Entity\Treso\Facture; 
use App\Entity\Project\Etude;

class ArchivageDocController extends AbstractController
{
    const docEtude = ['CDC', 'PC', 'CE', 'CCA', 'BDC', 'RM', 'AVRM', 'AVCE', 'PVRI', 'PVRF', 'QS' ];

    /**
     * @Route("archivage/doc", name="archivage_doc")
     */
    public function index(): Response
    {      
        $docEtude = self::docEtude;
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository(Document::class)->findAll();
        $factures = $em->getRepository(Facture::class)->getFactures();
        $etudes = $em->getRepository(Etude::class)->findAll();
        $totalSize = 0;
        foreach ($entities as $entity) {
            $totalSize += $entity->getSize();
        }
        return $this->render('GestionDocuments/archivage_doc/index.html.twig', [
            'controller_name' => 'ArchivageDocController',
            'docs' => $entities,
            'totalSize' => $totalSize,
            'factures' => $factures,
            'etudes' => $etudes,
            'docEtude' => $docEtude,
        ]);
    }
}
