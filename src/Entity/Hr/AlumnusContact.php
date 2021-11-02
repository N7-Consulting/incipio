<?php

namespace App\Entity\Hr;

use App\Entity\Personne\Membre;
use App\Repository\Hr\AlumnusContactRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AlumnusContactRepository::class)
 */
class AlumnusContact
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Alumnus
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Hr\Alumnus", inversedBy="alumnusContact", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $alumnus;

    /**
     * @var Membre
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Personne\Membre")
     * @ORM\JoinColumn(nullable=false)
     */
    private $faitPar;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $objet;

    /**
     * @var string
     * @ORM\Column(name="contenu", type="text")
     */
    private $contenu;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $moyenContact;

    public function __construct()
    {
        $this->date = new \DateTime('now');
    }

    /**
     * Set faitPar.
     *
     * @return AlumnusContact
     */
    public function setFaitPar(Membre $faitPar)
    {
        $this->faitPar = $faitPar;

        return $this;
    }

    /**
     * Get faitPar.
     *
     * @return Membre
     */
    public function getFaitPar()
    {
        return $this->faitPar;
    }

    /**
     * Get alumnus.
     *
     * @return Alumnus
     */
    public function getAlumnus()
    {
        return $this->alumnus;
    }

    /**
     * Set alumnus.
     *
     * @return AlumnusContact
     */
    public function setAlumnus(Alumnus $alumnus)
    {
        $this->alumnus = $alumnus;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getObjet(): ?string
    {
        return $this->objet;
    }

    public function setObjet(?string $objet): self
    {
        $this->objet = $objet;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(?string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getMoyenContact(): ?string
    {
        return $this->moyenContact;
    }

    public function setMoyenContact(?string $moyenContact): self
    {
        $this->moyenContact = $moyenContact;

        return $this;
    }
}
