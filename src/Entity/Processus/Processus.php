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
     * @var UploadedFile 
     *
     * 
     */
    private $fiche;

    

    //////
    /////

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFiche(): ?UploadedFile
    {
        return $this->fiche;

    }public function setFiche(UploadedFile $fiche = null): self
    {
        $this->fiche = $fiche;

        return $this;
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
