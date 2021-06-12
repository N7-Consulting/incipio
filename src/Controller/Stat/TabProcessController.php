<?php

namespace App\Controller\Stat;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TabProcessController extends AbstractController
{
    /**
     * @Route("/tab/process", name="tab_process")
     */
    public function index(): Response
    {
        return $this->render('Stat/tab_process/index.html.twig', [
            'controller_name' => 'TabProcessController',
        ]);
    }
}
