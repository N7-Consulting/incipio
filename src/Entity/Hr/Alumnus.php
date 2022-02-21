<?php

namespace App\Entity\Hr;

use App\Entity\Personne\AnonymizableInterface;
use App\Entity\Personne\Membre;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="App\Repository\Hr\AlumnusRepository")
 */
class Alumnus implements AnonymizableInterface
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
     * @var Membre
     * @ORM\OneToOne(targetEntity="App\Entity\Personne\Membre", inversedBy="alumnus", cascade={"persist"} )
     * @ORM\JoinColumn(nullable=true)
     */
    private $membre;

    /**
     * @var string
     *
     * @ORM\Column(name="commentaire", type="string", nullable=true)
     */
    private $commentaire;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"gdpr"})
     */
    private $lienLinkedIn;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"gdpr"})
     */
    private $posteActuel;

    /**
     * @ORM\OneToMany(targetEntity="AlumnusContact", mappedBy="alumnus", cascade={"persist", "remove"})
     * @ORM\OrderBy({"date" = "DESC"})
     */
    private $alumnusContact;

    /**
     * @var string
     *
     * @ORM\Column(name="secteurActuel", type="integer", nullable=true)
     * @Assert\Choice(callback = "getSecteurChoiceAssert")
     * @Groups({"gdpr"})
     */
    private $secteurActuel;

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
     * Set membre.
     *
     * @param Membre $membre
     *
     * @return Alumnus
     */
    public function setMembre(Membre $membre = null)
    {
        $this->membre = $membre;

        return $this;
    }

    /**
     * Get membre.
     *
     * @return Membre
     */
    public function getMembre()
    {
        return $this->membre;
    }

    /**
     * Add contacts.
     *
     * @return AlumnusContact
     */
    public function getAlumnusContact()
    {
        return $this->alumnusContact;
    }

    /**
     * Remove AlumnusContact.
     */
    public function removeAlumnusContact(AlumnusContact $alumnusContact)
    {
        $this->alumnusContact->removeElement($alumnusContact);
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

    /**
     * Get secteur.
     *
     * @return string
     */
    public function getSecteurActuel()
    {
        return $this->secteurActuel;
    }

    /**
     * Set secteur.
     *
     * @param string $secteur
     *
     * @return Alumnus
     */
    public function setSecteurActuel($secteurActuel)
    {
        $this->secteurActuel = $secteurActuel;

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
            16 => 'Tourisme  / Voyage',
        ];
    }

    public static function getSecteurChoiceAssert()
    {
        return array_keys(self::getSecteurChoice());
    }

    public function getSecteurToString()
    {
        if (!$this->secteurActuel) {
            return '';
        }
        $tab = $this->getSecteurChoice();

        return $tab[$this->secteurActuel];
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

    /**
     * {@inheritdoc}
     */
    public function anonymize(): void
    {
        $this->commentaire = null;
        $this->posteActuel = null;
        $this->lienLinkedIn = null;
        $this->secteurActuel = null;

        foreach ($this->alumnusContact as $contact) {
            $this->removeAlumnusContact($contact);
        }
    }
}
