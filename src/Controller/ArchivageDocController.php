<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArchivageDocController extends AbstractController
{
    /**
     * @Route("/archivage/doc", name="archivage_doc")
     */
    public function index(): Response
    {
        return $this->render('archivage_doc/index.html.twig', [
            'controller_name' => 'ArchivageDocController',
        ]);
    }
}
