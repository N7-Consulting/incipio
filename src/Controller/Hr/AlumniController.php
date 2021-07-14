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
        $entities = $this->getDoctrine()->getManager()->getRepository(Competence::class)->findBy([], ['nom' => 'asc']);

        return $this->render('Hr/Alumni/index.html.twig', [
            //'competences' => $entities,
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
        //$Alumnuscontact->setAlumnus($alumnus);
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

}
