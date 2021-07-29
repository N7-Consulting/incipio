<?php

namespace App\Entity\Excel;

use App\Entity\Personne\Personne;
use App\Entity\Personne\Membre;
use App\Entity\Personne\Filiere;
use App\Entity\Hr\Alumnus;
use Doctrine\ORM\Mapping as ORM;


/**
 * 
 */

class CreerDataAlumni implements CreerDataInterface
{
    public function creerData($donnees, $em, $flashbag)
        {   
            $raw = 1;
            foreach ($donnees as $data){
                if ($data['A'] && $data['B'] && $raw > 1 ){
                    $valide = true;
                    $prenom = $data['A'];
                    $nom = $data['B'];

                    // Si le membre existe, on récupère ses données 
                    $personne = $em->getRepository(Personne::class)->findOneBy(['prenom' => $prenom,'nom' => $nom,]);
                    if ($em->getRepository(Membre::class)->findOneBy(['personne' => $personne])){
                        $membre = $em->getRepository(Membre::class)->findOneBy(['personne' => $personne]);
                        if ($em->getRepository(Alumnus::class)->findOneBy(['personne' => $membre])){
                            $valide = false;
                            $flashbag->add('error', 'Les données de l\'alumnus '. $data['A'] .' '. $data['B'].' ne sont pas importées car ce dernier est déjà enregistré en tant qu\'alumnus.');
                        }
                    } else{
                        $valide = false;
                        $flashbag->add('error', 'Les données de l\'alumnus '. $data['A'] .' '. $data['B'].' ne sont pas importées car celui-ci n\'est pas enregistré comme membre.');

                    }
                    
                }
                else{
                    if ($raw > 1 && ($data['C'] || $data['D'] || $data['E'] || $data['F'])) {
                        $valide = false;
                        $flashbag->add('error', 'L\'alumnus de la ligne '. $raw .' n\'est pas enregistré car le nom ou le prénom n\'est pas renseigné.');
                    }
                }
                
                if ($raw >1 && $valide){
                    $al = new Alumnus();
                    $data['D'] ? $al->setCommentaire($data['D']) : $flashbag->add('danger', 'La colonne D de la ligne '. $raw .' n\'est pas complétée.');
                    $data['E'] ? $al->setLienLinkedIn($data['E']) : $flashbag->add('danger', 'La colonne E de la ligne '. $raw .' n\'est pas complétée.');
                    $data['F'] ? $al->setPosteActuel($data['F']) : $flashbag->add('danger', 'La colonne C de la ligne '. $raw .' n\'est pas complétée.');
                    
                    if ($data['C']){
                        if (array_key_exists($data['C'], Alumnus::getSecteurChoice())){
                            $al->setSecteurActuel($data['C']);
                        }else{
                            $flashbag->add('danger', 'Le secteur d\'activité de l\'alumnus '. $data['A'] .' '. $data['B'].' n\'est pas valide.');
                        }
                    }else{
                        $flashbag->add('danger', 'La colonne C de la ligne '. $raw .' n\'est pas complétée.');
                    }
                    
                    $membre->setAlumnus($al);
                    
                    $flashbag->add('succes', 'L\'alumnus '. $data['A'].' '. $data['B'].' a bien été enregistré.');
                    $em->getManager()->persist($al);
                    $em->getManager()->flush();
                }
                $raw ++;
            }
        }
}