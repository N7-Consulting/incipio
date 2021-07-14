<?php

namespace App\Entity\Hr;

use App\Entity\User\User;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Personne\Personne;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="App\Repository\Personne\PersonneRepository")
 */
class Alumnus
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var Personne
     *
     * @ORM\OneToOne(targetEntity="App\Entity\Personne\Personne")
     * @ORM\JoinColumn(nullable=true)
     * 
     */
    private $personne;

    /**
     * @var string
     *
     * @ORM\Column(name="commentaire", type="text")
     * @Assert\NotBlank
     */
    private $commentaire;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set commentaire.
     *
     * @param string $commentaire
     *
     * @return Alumnus
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Get commentaire.
     *
     * @return string
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * Set personne.
     *
     * @param Personne $personne
     *
     * @return Alumnus
     */
    public function setPersonne($personne)
    {
        $this->personne = $personne;

        return $this;
    }

    /**
     * Get personne.
     *
     * @return Personne
     */
    public function getPersonne()
    {
        return $this->personne;
    }
}
