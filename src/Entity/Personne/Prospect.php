<?php

/*
 * This file is part of the Incipio package.
 *
 * (c) Florian Lefevre
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity\Personne;

use App\Entity\Comment\Thread;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table()
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="App\Repository\Personne\ProspectRepository")
 */
class Prospect extends Adressable
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="Employe", mappedBy="prospect")
     */
    private $employes;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Comment\Thread", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $thread;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     *
     * @Groups({"gdpr"})
     *
     * @ORM\Column(name="nom", type="string", length=63)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="entite", type="integer", nullable=true)
     * @Assert\Choice(callback = "getEntiteChoiceAssert")
     */
    private $entite;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $mail;

    /**
     * @var string
     *
     * @ORM\Column(name="secteurActivite", type="integer", nullable=true)
     * @Assert\Choice(callback = "getSecteurChoiceAssert")
     */
    private $secteurActivite;

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
     * @ORM\PostPersist
     */
    public function createThread(LifecycleEventArgs $args)
    {
        if (null === $this->getThread()) {
            $em = $args->getObjectManager();
            $t = new Thread();
            $t->setId('prospect_' . $this->getId());
            $t->setPermalink('fake');
            $this->setThread($t);
            $em->persist($t);
            $em->flush();
        }
    }

    public function __toString()
    {
        return 'Prospect ' . $this->nom;
    }

    /**
     * Set thread.
     *
     * @return Prospect
     */
    public function setThread(Thread $thread)
    {
        $this->thread = $thread;

        return $this;
    }

    /**
     * Get thread.
     *
     * @return Thread
     */
    public function getThread()
    {
        return $this->thread;
    }

    /**
     * Add employes.
     *
     * @return Prospect
     */
    public function addEmploye(Employe $employes)
    {
        $this->employes[] = $employes;

        return $this;
    }

    /**
     * Remove employes.
     */
    public function removeEmploye(Employe $employes)
    {
        $this->employes->removeElement($employes);
    }

    /**
     * Get employes.
     *
     * @return ArrayCollection
     */
    public function getEmployes()
    {
        return $this->employes;
    }

    /**
     * Set nom.
     *
     * @param string $nom
     *
     * @return Prospect
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom.
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->employes = new ArrayCollection();
    }

    /**
     * Set entite.
     *
     * @param string $entite
     *
     * @return Prospect
     */
    public function setEntite($entite)
    {
        $this->entite = $entite;

        return $this;
    }

    /**
     * Get secteur.
     *
     * @return string
     */
    public function getSecteurActivite()
    {
        return $this->secteurActivite;
    }

    /**
     * Set secteur.
     * @param string $secteur
     * @return Prospect
     */
    public function setSecteurActivite($secteurActivite)
    {
        $this->secteurActivite = $secteurActivite;

        return $this;
    }

    public static function getSecteurChoice()
    {
        return [
            1 => 'Aéronautique',
            2 => 'BTP',
            3 => 'Développement Durable',
            4 => 'Conseil / Service',
            5 => 'Informatique et Télécommunication',
            6 => 'Agro-Alimentaire',
            7 => 'Informatique',
            8 => 'Spatial',
            9 => 'Energies',
            10 => 'Loisir / Culture / Restauration / Hôtellerie',
            11 => 'Finance / Banque / Assurance',
            12 => 'Commerce',
            13 => 'Enseignement',
            14 => 'Immobilier / Logement',
            15 => 'Transports',
            16 => 'Tourisme  / Voyage'
        ];
    }
    
    public static function getSecteurChoiceAssert()
    {
        return array_keys(self::getSecteurChoice());
    }
    
    public function getSecteurToString()
    {
        if (!$this->secteurActivite) {
            return '';
        }
        $tab = $this->getSecteurChoice();
    
        return $tab[$this->secteurActivite];
    }

    /**
     * Get entite.
     *
     * @return string
     */
    public function getEntite()
    {
        return $this->entite;
    }

    public static function getEntiteChoice()
    {
        return [
            1 => 'TPE (Très Petite Entreprise moins de 10 salariés)',
            2 => 'PME (Petite ou Moyenne Entreprise, 10 - 250 salariés)',
            3 => 'ETI (Entreprise de Taille Intermédiaire, 250 - 5000 salariés)',
            4 => 'Grand groupes (+ 5000 salariés)',
            5 => 'Ecole',
            6 => 'Administrations Publiques (Mairie, Régions, Département, Cci, Ecole, Laboratoire, Association)',
            7 => 'Junior-Entreprise',
            8 => 'Particulier',
            9 => 'Association',
            10 => 'Startup / Indépendant(e)'
            ];
    }

    // public static function entiteExist($choix, $cle)
    // {
    //     foreach (self::getEntiteChoice() as $num=>$entite){
            
    //         if (strcmp($choix, $entite) == 0){
    //             $cle = $num; 
    //             return true;
    //         }
    //     }
    //     return false;
    // }

    public static function getEntiteChoiceAssert()
    {
        return array_keys(self::getEntiteChoice());
    }

    public function getEntiteToString()
    {
        if (!$this->entite) {
            return '';
        }
        $tab = $this->getEntiteChoice();

        return $tab[$this->entite];
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(?string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }
}
