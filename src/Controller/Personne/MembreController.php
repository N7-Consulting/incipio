<?php

/*
 * This file is part of the Incipio package.
 *
 * (c) Florian Lefevre
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\Personne;

use App\Entity\Personne\Membre;
use App\Entity\Publish\RelatedDocument;
use App\Form\Personne\MembreType;
use App\Service\Project\EmailEtuManager;
use App\Service\Publish\DocumentManager;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

class MembreController extends AbstractController
{
    /**
     * @Security("has_role('ROLE_SUIVEUR')")
     * @Route(name="personne_membre_homepage", path="/membres", methods={"GET","HEAD"})
     *
     * @return Response
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository(Membre::class)->getMembres();

        return $this->render('Personne/Membre/index.html.twig', [
            'membres' => $entities,
        ]);
    }

    /**
     * @Security("has_role('ROLE_SUIVEUR')")
     * @Route(name="personne_intervenants_homepage", path="/intervenants", methods={"GET","HEAD"})
     *
     * @return Response
     */
    public function listIntervenants()
    {
        $em = $this->getDoctrine()->getManager();
        $intervenants = $em->getRepository(Membre::class)->getByMissionsNonNul();

        return $this->render('Personne/Membre/indexIntervenants.html.twig', [
            'intervenants' => $intervenants,
        ]);
    }

    /**
     * @Security("has_role('ROLE_SUIVEUR')")
     * @Route(name="personne_membres_homepage", path="/membres-actifs", methods={"GET","HEAD"})
     *
     * @return Response
     */
    public function statistique(ObjectManager $em)
    {
        $entities = $em->getRepository(Membre::class)->findAll();

        $membresActifs = [];
        /** @var Membre $membre */
        foreach ($entities as $membre) {
            foreach ($membre->getMandats() as $mandat) {
                if ('Membre' == $mandat->getPoste()
                        ->getIntitule() && $mandat->getDebutMandat() < new \DateTime('now') && $mandat->getFinMandat() > new \DateTime('now')
                ) {
                    $membresActifs[] = $membre;
                }
            }
        }

        return $this->render('Personne/Membre/index.html.twig', [
            'membres' => $membresActifs,
        ]);
    }

    /**
     * @Security("has_role('ROLE_ELEVE')")
     * @Route(name="personne_membre_voir", path="/membres/voir/{id}", methods={"GET","HEAD"})
     *
     * @return Response
     */
    public function voir(Membre $membre, ObjectManager $em)
    {
        /** @var Membre $membre */
        $membre = $em->getRepository(Membre::class)->getMembreCompetences($membre->getId());

        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN') &&
            $membre->getPersonne() && !$membre->getPersonne()->getUser()
        ) {
            $create_user_form = $this->createFormBuilder(['id' => $membre->getPersonne()->getId()])
                ->add('id', HiddenType::class)
                ->setAction($this->generateUrl('user_addFromPersonne', ['id' => $membre->getPersonne()->getId()]))
                ->setMethod('POST')
                ->getForm();
        }

        return $this->render('Personne/Membre/voir.html.twig', [
            'membre' => $membre,
            'create_user_form' => (isset($create_user_form) ? $create_user_form->createView() : null),
        ]);
    }

    /**
     * @Security("has_role('ROLE_SUIVEUR')")
     * @Route(name="personne_membre_ajouter", path="/membres/add", methods={"GET","HEAD","POST"})
     *
     * @return RedirectResponse|Response
     */
    public function ajouter(
        Request $request,
        DocumentManager $documentManager,
        EmailEtuManager $emailEtuManager,
        RouterInterface $router
    ) {
        $em = $this->getDoctrine()->getManager();

        $membre = new Membre();

        $now = new \DateTime('now');
        $now->modify('+ 3 year');

        $membre->setPromotion($now->format('Y'));

        $birth = new \DateTime('now');
        $birth->modify('- 20 year');
        $membre->setDateDeNaissance($birth);

        $form = $this->createForm(MembreType::class, $membre);

        if ('POST' == $request->getMethod()) {
            $form->handleRequest($request);
            $photoUpload = $form->get('photo')->getData();

            if ($form->isValid()) {
                // Mail étudiant
                if (!$membre->getEmailEMSE()) {
                    $membre->setEmailEMSE($emailEtuManager->getEmailEtu($membre));
                }

                /*
                 * Traitement de l'image de profil
                 */
                if ($membre->getPersonne()) {
                    $authorizedMIMEType = ['image/jpeg', 'image/png', 'image/bmp'];
                    $photoInformation = new RelatedDocument();
                    $photoInformation->setMembre($membre);
                    $name = 'Photo - ' . $membre->getIdentifiant() . ' - ' . $membre->getPersonne()->getPrenomNom();

                    if ($photoUpload) {
                        $document = $documentManager->uploadDocumentFromFile(
                            $photoUpload,
                            $authorizedMIMEType,
                            $name,
                            $photoInformation,
                            true
                        );
                        $membre->setPhotoURI($router->generate(
                            'publish_document_voir',
                            ['id' => $document->getId()]
                        ));
                    }
                }

                if (!$membre->getIdentifiant()) {
                    $initial = substr($membre->getPersonne()->getPrenom(), 0, 1) . substr($membre->getPersonne()
                            ->getNom(), 0, 1);
                    $ident = count($em->getRepository(Membre::class)->findBy(['identifiant' => $initial])) + 1;
                    while ($em->getRepository(Membre::class)->findOneBy(['identifiant' => $initial . $ident])) {
                        ++$ident;
                    }
                    $membre->setIdentifiant(strtoupper($initial . $ident));
                }

                $em->persist($membre);
                $em->flush();
                $this->addFlash('success', 'Membre enregistré');

                return $this->redirectToRoute('personne_membre_voir', ['id' => $membre->getId()]);
            }
            //form invalid
            $this->addFlash('danger', 'Le formulaire contient des erreurs.');
        }

        return $this->render('Personne/Membre/ajouter.html.twig', [
            'form' => $form->createView(),
            'photoURI' => $membre->getPhotoURI(),
        ]);
    }

    /**
     * @Security("has_role('ROLE_SUIVEUR')")
     * @Route(name="personne_membre_modifier", path="/membres/modifier/{id}", methods={"GET","HEAD","POST"})
     *
     * @return RedirectResponse|Response
     *
     * @internal param $id
     */
    public function modifier(Request $request, Membre $membre, DocumentManager $documentManager, RouterInterface $router)
    {
        $em = $this->getDoctrine()->getManager();

        $deleteForm = $this->createDeleteForm($membre->getId());

        $form = $this->createForm(MembreType::class, $membre);

        if ('POST' == $request->getMethod()) {
            $form->handleRequest($request);
            $photoUpload = $form->get('photo')->getData();

            if ($form->isValid()) {
                /*
                 * Traitement de l'image de profil
                 */
                if ($membre->getPersonne()) {
                    $authorizedMIMEType = ['image/jpeg', 'image/png', 'image/bmp'];
                    $photoInformation = new RelatedDocument();
                    $photoInformation->setMembre($membre);
                    $name = 'Photo - ' . $membre->getIdentifiant() . ' - ' . $membre->getPersonne()->getPrenomNom();

                    if ($photoUpload) {
                        $document = $documentManager->uploadDocumentFromFile(
                            $photoUpload,
                            $authorizedMIMEType,
                            $name,
                            $photoInformation,
                            true
                        );
                        $membre->setPhotoURI($router->generate(
                            'publish_document_voir',
                            ['id' => $document->getId()]
                        ));
                    }
                }

                $em->persist($membre);
                $em->flush();
                $this->addFlash('success', 'Membre enregistré');

                return $this->redirectToRoute('personne_membre_voir', ['id' => $membre->getId()]);
            }
            //form invalid
            $this->addFlash('danger', 'Le formulaire contient des erreurs.');
        }

        return $this->render('Personne/Membre/modifier.html.twig', [
            'form' => $form->createView(),
            'delete_form' => $deleteForm->createView(),
            'photoURI' => $membre->getPhotoURI(),
        ]);
    }

    /**
     * @Security("has_role('ROLE_SUIVEUR')")
     * @Route(name="personne_membre_supprimer", path="/membres/supprimer/{id}", methods={"HEAD","POST"})
     *
     * @return RedirectResponse
     */
    public function delete(Request $request, Membre $membre, ObjectManager $em)
    {
        $form = $this->createDeleteForm($membre->getId());
        $form->handleRequest($request);

        if ($form->isValid()) {
            if ($membre->getPersonne()) {
                $membre->getPersonne()->setMembre(null);
                if ($membre->getPersonne()->getUser()) {
                    // pour pouvoir réattribuer le compte
                    $membre->getPersonne()->getUser()->setPersonne(null);
                }
                $membre->getPersonne()->setUser(null);
            }
            $membre->setPersonne(null);
            $membre->setAlumnus(null);
            //est-ce qu'on supprime la personne aussi ?

            $em->remove($membre);
            $em->flush();
            $this->addFlash('success', 'Membre supprimé');
        }

        return $this->redirectToRoute('personne_membre_homepage');
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(['id' => $id])
            ->add('id', HiddenType::class)
            ->getForm();
    }

    /**
     * @Security("has_role('ROLE_SUIVEUR')")
     * @Route(name="personne_membre_impayes", path="/membres/impayes", methods={"GET","HEAD"})
     *
     * @return Response
     */
    public function impayes()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository(Membre::class)->findByformatPaiement('aucun');

        return $this->render('Personne/Membre/impayes.html.twig', [
            'membres' => $entities,
        ]);
    }
}
