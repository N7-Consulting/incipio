<?php

namespace App\Controller\Excel;

use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;

// use App\Entity\Personne\Personne;
// use App\Entity\Personne\Filiere;
// use App\Entity\Hr\Alumnus;

use App\Entity\Excel\CreerDataAlumni;

use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use App\Service\Publish\DocumentManager;
use App\Form\Publish\DocumentType;
use App\Entity\Publish\Document;
use Symfony\Component\HttpKernel\KernelInterface;
use App\Entity\Hr\Competence;
use App\Entity\Project\Etude;
use App\Form\Hr\CompetenceType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\Project\EtudePermissionChecker;
use App\Entity\Hr\AlumnusContact;
use App\Form\Hr\AlumnusContactType;
use App\Form\Hr\AlumnusContactHandler;
use App\Form\Hr\AlumnusType;
use App\Form\Hr\AlumnusHandler;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\File;
use PhpOffice\PhpSpreadsheet\Reader\Csv as CsvReader;
use PhpOffice\PhpSpreadsheet\Writer\Csv as CsvWriter;
use PhpOffice\PhpSpreadsheet\Writer\Exception as WriterException;
use PhpOffice\PhpSpreadsheetTests\Functional;
use App\Entity\Personne\Membre;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;



class ExcelController extends AbstractController 
{
    /**
     * @Security("has_role('ROLE_ADMIN')")
     * @Route(name="excel_index", path="/import/excel/{fileName},{classe},{fileNameType}", methods={"GET","HEAD"})
     */
    public function excelIndex($fileName, $classe, $fileNameType)
    {   
        return $this->render('Excel/index.html.twig', [
            'fileName' => $fileName,
            'fileNameType' => $fileNameType,
            'classe' => $classe,
        ]);
    }

    private function readExcel($inputFileName)
    {
        $spreadsheet = new Spreadsheet();
        $spreadsheet = IOFactory::load($inputFileName);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        //var_dump($sheetData); // Décommenter pour voir le tableau des données
        return $sheetData;
    }

    /**
     * @Security("has_role('ROLE_SUIVEUR')")
     * @Route(name="migrations", path="/excel/alumni/donnees/{classe}, {fileName}", methods={"GET","HEAD","POST"})
     * 
     */
    public function migrations($fileName, $classe)//$filename, $classe
        {
            $inputFileName = '/app/var/documents/'. $fileName;
            $em = $this->getDoctrine(); 
            $data = [];
            $data = $this->readExcel($inputFileName);
            
            $session = new Session();
            $session->clear();
            $flashbag = $session->getFlashBag();
            $classe::creerData($data,$em, $flashbag);

            $error = [];
            $danger = [];
            $succes = [];
            foreach ($session->getFlashBag()->all() as $type => $messages) {
                switch ($type) {
                    case "error" : $error [] = $messages;
                        break;
                    case "danger" : $danger [] = $messages;
                        break;
                    case "succes" : $succes [] = $messages;
                        break;
                }
            }

            return $this->render('Excel/resultats.html.twig', [
                'error' => $error,
                'danger' => $danger,
                'succes' => $succes
            ]);
        }

    /**
     * @Security("has_role('ROLE_SUIVEUR')")
     * @Route(name="bdd_type", path="/document/type/{fileNameType}", methods={"GET","HEAD"})
     * @return BinaryFileResponse
     * @throws \Exception
     */
    public function voir(KernelInterface $kernel, $fileNameType)
    {
        $documentStoragePath = $kernel->getProjectDir() . '' . Document::DOCUMENT_STORAGE_ROOT;
        if (file_exists($documentStoragePath . '/'. $fileNameType)) {
            $response = new BinaryFileResponse($documentStoragePath .'/'. $fileNameType);
            $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT);
            return $response;
        } else {
            throw new \Exception($documentStoragePath .'/'. $fileNameType . 'n\'existe pas');
        }
    }

    /**
     * @Security("has_role('ROLE_SUIVEUR')")
     * @Route(name="upload_fichier_excel", path="/upload/{fileName},{classe},{fileNameType}", methods={"GET","HEAD","POST"})
     *
     * @return Response
     */
    public function uploadExcel(
        Request $request,
        DocumentManager $documentManager,
        KernelInterface $kernel,
        $fileName,
        $classe,
        $fileNameType
    ) {
        if (!$response = $this->upload($request, true, $documentManager, $kernel, $fileName)) {
            $this->addFlash('success', 'Document mis en ligne');
            return $this->redirectToRoute('excel_index', ['fileName' => $fileName,'classe' => $classe,'fileNameType' => $fileNameType]);
        }
        return $response;
    }

    private function upload(
        Request $request,
        $deleteIfExist = false,
        DocumentManager $documentManager,
        KernelInterface $kernel,
        String $path
    ) {
        $document = new Document();
        $document->setProjectDir($kernel->getProjectDir());
        $document->setPath($path);
        $form = $this->createForm(DocumentType::class, $document, []);

        if ('POST' == $request->getMethod()) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $documentManager->uploadDocument($document);
                return false;
            }
        }
        return $this->render('Publish/Document/upload.html.twig', ['form' => $form->createView()]);
    }
}