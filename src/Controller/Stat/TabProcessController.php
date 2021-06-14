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

        $processus = new Processus();
        $listProcess = $em->getRepository(Processus::class)->findAll();
        $document = $em->getRepository(Document::class)->findAll();
        
        $form = $this->createForm(ProcessType::class, $processus);

        if ('POST' == $request->getMethod()) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em->persist($processus);
             $em->flush();
            //     //$this->addFlash('success', 'Processus ajouté');

                return $this->redirectToRoute('tab_process');
            }
            $this->addFlash('danger', 'Le formulaire contient des erreurs.');
        }
        
        return $this->render('Stat/tab_process/index.html.twig', [
            'controller_name' => 'TabProcessController',
            'form' => $form->createView(),
            'listProcess' => $listProcess,
            'docs' => $document
        ]);
    }
 


/**
     * @Security("has_role('ROLE_CA')")
     * @Route(name="processus_voir", path="/FicheProcessus/show/{id}", methods={"GET","HEAD"})
     *
     * @param fiche $ficheProcess (ParamConverter) The document to be downloaded
     *
     * @return BinaryFileResponse
     *
     * @throws \Exception
     */
    public function voir(Document $fiche, KernelInterface $kernel)
    {
        $documentStoragePath = $kernel->getProjectDir() . '' . Document::DOCUMENT_STORAGE_ROOT;
        if (file_exists($documentStoragePath . '/' . $fiche->getPath())) {
            $response = new BinaryFileResponse($documentStoragePath . '/' . $ficheProcess->getPath());
            $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT);

            return $response;
        } else {
            throw new \Exception($documentStoragePath . '/' . $fiche->getPath() . ' n\'existe pas');
        }
    }

     /**
     * @Security("has_role('ROLE_ADMIN')")
     * @Route(name="publish_document_uploadDoctype", path="/Documents/Upload/Doctype", methods={"GET","HEAD","POST"})
     *
     * @return Response
     */
    public function uploadDoctype(Request $request, DocumentManager $documentManager, KernelInterface $kernel)
    {
        if (!$response = $this->upload($request, true, [], $documentManager, $kernel)) {
            // Si tout est ok
            return $this->redirectToRoute('publish_documenttype_index');
        } else {
            return $response;
        }
    }

    private function upload(
        Request $request,
        $deleteIfExist = false,
        $options = [],
        DocumentManager $documentManager,
        KernelInterface $kernel
    ) {
        $document = new Document();
        $document->setProjectDir($kernel->getProjectDir());
        if (count($options)) {
            $relatedDocument = new RelatedDocument();
            $relatedDocument->setDocument($document);
            $document->setRelation($relatedDocument);
            if (array_key_exists('etude', $options)) {
                $relatedDocument->setEtude($options['etude']);
            }
            if (array_key_exists('etudiant', $options)) {
                $relatedDocument->setMembre($options['etudiant']);
            }
        }

        $form = $this->createForm(DocumentType::class, $document, $options);

        if ('POST' == $request->getMethod()) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $documentManager->uploadDocument($document, null, $deleteIfExist);

                return false;
            }
        }

        return $this->render('Publish/Document/upload.html.twig', ['form' => $form->createView()]);
    }
}