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
     * @ORM\Column(name="commentaire", type="string", nullable=true)
     */
    private $commentaire;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lienLinkedIn;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $secteurActuel;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $posteActuel;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function setCommentaire(?string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getCommentaire(): ?string
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

    public function getLienLinkedIn(): ?string
    {
        return $this->lienLinkedIn;
    }

    public function setLienLinkedIn(?string $lienLinkedIn): self
    {
        $this->lienLinkedIn = $lienLinkedIn;

        return $this;
    }

    public function getSecteurActuel(): ?string
    {
        return $this->secteurActuel;
    }

    public function setSecteurActuel(?string $secteurActuel): self
    {
        $this->secteurActuel = $secteurActuel;

        return $this;
    }

    public function getPosteActuel(): ?string
    {
        return $this->posteActuel;
    }

    public function setPosteActuel(?string $posteActuel): self
    {
        $this->posteActuel = $posteActuel;

        return $this;
    }
}
