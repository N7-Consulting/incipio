<?php

/*
 * This file is part of the Incipio package.
 *
 * (c) Florian Lefevre
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace mgate\SuiviBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * mgate\SuiviBundle\Entity\Ap.
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Ap extends DocType
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
     * @ORM\OneToOne(targetEntity="Etude", inversedBy="ap")
     * @ORM\JoinColumn(nullable=false, onDelete="cascade")
     */
    protected $etude;

    /** nombre de developpeur estimé
     * @var int
     *
     * @ORM\Column(name="nbrDev", type="integer", nullable=true)
     */
    private $nbrDev;

    /**
     * @ORM\ManyToOne(targetEntity="mgate\PersonneBundle\Entity\Personne")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $contactMgate;

    /**
     * @var bool
     *
     * @ORM\Column(name="deonto", type="boolean", nullable=true)
     */
    private $deonto;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function getReference()
    {
        return $this->etude->getReference().'-AP-'.$this->getVersion();
    }

    /**
     * Set etude.
     *
     * @param mgate\SuiviBundle\Entity\Etude $etude
     *
     * @return Ap
     */
    public function setEtude(\mgate\SuiviBundle\Entity\Etude $etude = null)
    {
        $this->etude = $etude;

        return $this;
    }

    /**
     * Get etude.
     *
     * @return mgate\SuiviBundle\Entity\Etude
     */
    public function getEtude()
    {
        return $this->etude;
    }

    /**
     * Set nbrDev.
     *
     * @param int $nbrDev
     *
     * @return Ap
     */
    public function setNbrDev($nbrDev)
    {
        $this->nbrDev = $nbrDev;

        return $this;
    }

    /**
     * Get nbrDev.
     *
     * @return int
     */
    public function getNbrDev()
    {
        return $this->nbrDev;
    }

    /**
     * Set contactMgate.
     *
     * @param \mgate\PersonneBundle\Entity\Personne $contactMgate
     *
     * @return Ap
     */
    public function setContactMgate(\mgate\PersonneBundle\Entity\Personne $contactMgate = null)
    {
        $this->contactMgate = $contactMgate;

        return $this;
    }

    /**
     * Get contactMgate.
     *
     * @return \mgate\PersonneBundle\Entity\Personne
     */
    public function getContactMgate()
    {
        return $this->contactMgate;
    }

    /**
     * Set deonto.
     *
     * @param bool $deonto
     *
     * @return Ap
     */
    public function setDeonto($deonto)
    {
        $this->deonto = $deonto;

        return $this;
    }

    /**
     * Get deonto.
     *
     * @return bool
     */
    public function getDeonto()
    {
        return $this->deonto;
    }
}
