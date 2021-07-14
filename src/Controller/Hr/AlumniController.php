<?php

namespace App\Controller\Hr;

use App\Entity\Hr\Competence;
use App\Entity\Personne\Membre;
use App\Entity\Project\Etude;
use App\Form\Hr\CompetenceType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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

}
