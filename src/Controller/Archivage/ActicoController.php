<?php

namespace App\Controller\Archivage;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Publish\Document;
use App\Entity\Project\Etude;

class ActicoController extends AbstractController
{
    // TODO: Permettre d'afficher les éléments que l'on veut via le panel Administration
    // Correspondance colonnes tableau => nom dans l'entity Etude
    const docEtude = ['CETUDE' => 'ce','AV' => 'avs', 'PV' => 'procesVerbaux', 'RM' => 'missions'];
    // Path pour la génération du document via le Publipostage
    const rootName = ['CETUDE' => 'etude', 'AV' => 'etude', 'PV' => 'etude', 'RM' => 'mission'];
    // const docEtude = ['CDC' => 'cdc', 'PC' => 'pc', 'CETUDE' => 'ce', 'CCA' => 'cca', 'BDC' => 'bdc', 'RM' => 'missions', 'AV' => 'avs', 'PV' => 'procesVerbaux', 'QS' => 'qs'];

    /**
     * @Route("archivage/actico", name="archivage_actico_index")
     */
    public function index(): Response
    {
        $docEtude = self::docEtude;
        $rootName = self::rootName;
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository(Document::class)->findAll();
        $etudes = $em->getRepository(Etude::class)->findAll();

        return $this->render('Archivage/Actico/index.html.twig', [
            'controller_name' => 'ActicoController',
            'docs' => $entities,
            'docEtude' => $docEtude,
            'etudes' => $etudes,
            'rootName' => $rootName,
        ]);
    }
}
