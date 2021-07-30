<?php

namespace App\Entity\Excel;

/**
 * Interface pour rajouter des fonctions
 * permettant d'importer des données sur Jeyser.
 */
interface CreerDataInterface
{
    /**
     * @return array
     */
    public function creerData($donnees, $em, $flashbag);
}
