<?php

namespace App\Entity\Processus;

use App\Repository\Processus\ProcessusRepository;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ProcessusRepository::class)
 */
class Processus
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pilote;
    /////////
    ////////
       /**
     * @var Document Avant projet
     *
     * @ORM\OneToOne(targetEntity="App\Entity\Publish\Document")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $fiche;

    /**
     * Set fiche.
     *
     * @param Fiche $fiche
     *
     * @return Processus
     */
    public function setFiche(?Fiche $fiche = null)
    {
        $this->fiche = $fiche;
        return $this;
    }

    /**
     * Get fiche.
     *
     * @return Fiche
     */
    public function getFiche()
    {
        return $this->fiche;
    }


    //////
    /////

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPilote(): ?string
    {
        return $this->pilote;
    }

    public function setPilote(string $pilote): self
    {
        $this->pilote = $pilote;

        return $this;
    }
}
