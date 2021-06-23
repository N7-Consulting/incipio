<?php

namespace App\Entity\Processus;

use App\Repository\Processus\ProcessusRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Publish\RelatedDocument;
use Doctrine\Common\Collections\Collection;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpKernel\KernelInterface;

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

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Publish\RelatedDocument", mappedBy="processus", cascade={"remove"})
     */
    private $relatedDocuments;
    

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

    /**
     * Add relatedDocuments.
     *
     * @return Processus
     */
    public function addRelatedDocument(RelatedDocument $relatedDocuments)
    {
        $this->relatedDocuments[] = $relatedDocuments;

        return $this;
    }

    /**
     * Remove relatedDocuments.
     */
    public function removeRelatedDocument(RelatedDocument $relatedDocuments)
    {
        $this->relatedDocuments->removeElement($relatedDocuments);
    }

    /**
     * Get relatedDocuments.
     *
     * @return Collection
     */
    public function getRelatedDocuments()
    {
        return $this->relatedDocuments;
    }
}
