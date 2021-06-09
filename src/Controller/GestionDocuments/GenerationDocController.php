<?php

namespace App\Controller\GestionDocuments;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GenerationDocController extends AbstractController
{
    /**
     * @Route("generation/doc", name="generation_doc")
     */
    public function index(): Response
    {
        return $this->render('GestionDocuments/generation_doc/index.html.twig', [
            'controller_name' => 'GenerationDocController',
        ]);
    }
}
