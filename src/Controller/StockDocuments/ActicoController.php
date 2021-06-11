<?php

namespace App\Controller\StockDocuments;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Publish\Document;
use App\Entity\Project\Etude;

class ActicoController extends AbstractController
{
    const docEtude = ['CDC', 'PC', 'CE', 'CCA', 'BDC', 'RM', 'AVRM', 'AVCE', 'PVRI', 'PVRF', 'QS' ];

    /**
     * @Route("actico", name="actico")
     */
    public function index(): Response
    {   
        $docEtude = self::docEtude;
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository(Document::class)->findAll();
        $etudes = $em->getRepository(Etude::class)->findAll();

        return $this->render('StockDocuments/actico/index.html.twig', [
            'controller_name' => 'ActicoController',
            'docs' => $entities,
            'docEtude' => $docEtude,
            'etudes' => $etudes,
        ]);
    }
}
