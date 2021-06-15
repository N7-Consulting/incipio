<?php

namespace App\Controller\Stat;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Processus\Processus;
use App\Form\Processus\ProcessType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpKernel\KernelInterface;

use App\Entity\Publish\Document;
use App\Entity\Publish\RelatedDocument;
use App\Form\Publish\DocumentType;
use App\Service\Publish\DocumentManager;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use App\Controller\Stat\UploadedFile;


class TabProcessController extends AbstractController
{
    /**
     * @Route("/TabProcess", name="tab_process")
     */
    public function index(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $processus = $em->getRepository(Processus::class)->findAll();
        
        return $this->render('Stat/tab_process/index.html.twig', [
            'controller_name' => 'TabProcessController',
            'processus' => $processus,
        ]);
    }
 


/**
     * @Security("has_role('ROLE_CA')")
     * @Route(name="ajouter_processus", path="/Processus/Ajouter", methods={"GET","HEAD","POST"})
     *
     * @return Response
     */
    public function ajouter(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $processus = new Processus();
        $form = $this->createForm(ProcessType::class, $processus);

        if ('POST' == $request->getMethod()) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em->persist($processus);
                $em->flush();
                $this->addFlash('success', 'Processus enregistré');

                return $this->redirectToRoute('tab_process');
            }
            $this->addFlash('danger', 'Le formulaire contient des erreurs.');
        }

        return $this->render('Stat/tab_process/processus.html.twig',  ['form' => $form->createView()]
                                                                                
        );
    }
}