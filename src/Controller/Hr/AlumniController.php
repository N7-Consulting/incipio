<?php

namespace App\Controller\Hr;

use App\Entity\Hr\Competence;
use App\Entity\Personne\Personne;
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


class AlumniController extends AbstractController
{
    /**
     * @Security("has_role('ROLE_SUIVEUR')")
     * @Route(name="gestion_alumni", path="/rh/alumni", methods={"GET","HEAD"})
     */
    public function index()
    {
        $contacts = $this->getDoctrine()->getManager()->getRepository(AlumnusContact::class)->findAll();

        return $this->render('Hr/Alumni/index.html.twig', [
            'contacts' => $contacts,
        ]);
    }

    /**
     * @Security("has_role('ROLE_SUIVEUR')")
     * @Route(name="project_alumnuscontact_ajouter", path="/rh/alumnuscontact/ajouter/{id}", methods={"GET","HEAD","POST"})
     *
     * @return RedirectResponse|Response
     */
    public function add(Request $request, Personne $alumnus, EtudePermissionChecker $permChecker)
    {
        $em = $this->getDoctrine()->getManager();

        $Alumnuscontact = new AlumnusContact();
        $Alumnuscontact->setAlumnus($alumnus);
        $form = $this->createForm(AlumnusContactType::class, $Alumnuscontact);
        $formHandler = new AlumnusContactHandler($form, $request, $em);

        if ($formHandler->process()) {
            return $this->redirectToRoute('gestion_alumni');
        }

        return $this->render('Hr/Alumni/ajouter.html.twig', [
            'form' => $form->createView(),
            // 'etude' => $etude,
        ]);
    }

    /**
     * @Security("has_role('ROLE_SUIVEUR')")
     * @Route(name="alumni_contact_modifier", path="/hr/alumnus/contact/modifier/{id}", methods={"GET","HEAD","POST"})
     *
     * @return RedirectResponse|Response
     */
    public function modifier(Request $request, AlumnusContact $alumnusContact, EtudePermissionChecker $permChecker)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(AlumnusContactType::class, $alumnusContact);

        if ('POST' == $request->getMethod()) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em->flush();
                $this->addFlash('success', 'Contact modifié');

                return $this->redirectToRoute('gestion_alumni', ['_fragment' => 'contacts']);
            }
            $this->addFlash('danger', 'Le formulaire contient des erreurs.');
        }
        $deleteForm = $this->createDeleteForm($alumnusContact);

        return $this->render('Hr/Alumni/modifier.html.twig', [
            'form' => $form->createView(),
            'delete_form' => $deleteForm->createView(),
            'alumnusContact' => $alumnusContact,
            //'etude' => $etude,
        ]);
    }

    /**
     * @Security("has_role('ROLE_SUIVEUR')")
     * @Route(name="alumnus_contact_delete", path="/hr/alumnus/contact/supprimer/{id}", methods={"GET","HEAD","POST"})
     *
     * @return RedirectResponse
     */
    public function delete(AlumnusContact $contact, Request $request, EtudePermissionChecker $permChecker)
    {
        $form = $this->createDeleteForm($contact);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->remove($contact);
            $em->flush();
            $this->addFlash('success', 'Contact client supprimé');
        }

        return $this->redirectToRoute('gestion_alumni', ['_fragment' => 'contacts']);
    }

    private function createDeleteForm(AlumnusContact $contact)
    {
        return $this->createFormBuilder(['id' => $contact->getId()])
            ->add('id', HiddenType::class)
            ->getForm();
    }

}
