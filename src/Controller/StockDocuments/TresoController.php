<?php

namespace App\Controller\StockDocuments;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Treso\Facture; 
use App\Entity\Publish\Document;

class TresoController extends AbstractController
{
    const docEtude = ['CDC', 'PC', 'CE', 'CCA', 'BDC', 'RM', 'AVRM', 'AVCE', 'PVRI', 'PVRF', 'QS' ];

    /**
     * @Route("treso", name="treso")
     */
    public function index(): Response
    {   
        $docEtude = self::docEtude;
        $em = $this->getDoctrine()->getManager();
        $factures = $em->getRepository(Facture::class)->getFactures();
        $entities = $em->getRepository(Document::class)->findAll();

        return $this->render('StockDocuments/treso/index.html.twig', [
            'controller_name' => 'TresoController',
            'factures' => $factures,
            'docEtude' => $docEtude,
            'docs' => $entities,
        ]);
    }
}
