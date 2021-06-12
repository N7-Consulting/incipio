<?php

namespace App\Controller\Stat;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Processus\Processus;
use App\Form\Processus\ProcessType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class TabProcessController extends AbstractController
{
    /**
     * @Route("/tab/process", name="tab_process")
     */
    public function index(): Response
    {
        $em = $this->getDoctrine()->getManager();

        $processus = new Processus();
        $listProcess = $em->getRepository(Processus::class)->findAll();
        
        $form = $this->createForm(ProcessType::class, $processus);
        
        return $this->render('Stat/tab_process/index.html.twig', [
            'controller_name' => 'TabProcessController',
            'form' => $form->createView(),
            'listProcess' => $listProcess
        ]);
    }

/**
     * @Security("has_role('ROLE_SUIVEUR')")
     * @Route(name="personne_poste_ajouter", path="/poste/add", methods={"GET","HEAD","POST"})
     *
     * @return RedirectResponse|Response
     */
    public function ajouter(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $processus = new Processus();

        $form = $this->createForm(ProcessusType::class, $processus);

        if ('POST' == $request->getMethod()) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em->persist($processus);
                $em->flush();
                $this->addFlash('success', 'Processus ajouté');

                return $this->redirectToRoute('tab_process');
            }
            $this->addFlash('danger', 'Le formulaire contient des erreurs.');
        }

        return $this->render('Stat/tab_process/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}