<?php

namespace App\Entity\Excel;

use App\Entity\Personne\Prospect;
use App\Entity\Personne\Personne;
use App\Entity\Personne\Employe;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use Doctrine\ORM\Mapping as ORM;

class CreerDataProspect implements CreerDataInterface
{
    public function creerData($donnees, $em, $flashbag)
        {   
            $raw = 1;
            foreach ($donnees as $data){
                if ($data['A'] && $raw >1){
                    if ($em->getRepository(Prospect::class)->findOneBy(['nom' => $data['A']])){
                        $prospect = $em->getRepository(Prospect::class)->findOneBy(['nom' => $data['A']]);
                        $flashbag->add('danger', 'Le prospect de la ligne '. $raw .' a déjà été enregistré.');
                    } else {
                        $prospect = new Prospect();
                        $prospect->setNom($data['A']);
                        $data['C'] ? $prospect->setPays($data['C']) : $flashbag->add('danger', 'La colonne C de la ligne '. $raw .' n\'est pas complétée.');
                        $data['D'] ? $prospect->setVille($data['D']) : $flashbag->add('danger', 'La colonne D de la ligne '. $raw .' n\'est pas complétée.');
                        $data['E'] ? $prospect->setAdresse($data['E']) : $flashbag->add('danger', 'La colonne E de la ligne '. $raw .' n\'est pas complétée.');
                        $data['F'] ? $prospect->setCodePostal($data['F']) : $flashbag->add('danger', 'La colonne F de la ligne '. $raw .' n\'est pas complétée.');
                        $data['G'] ? $prospect->setMail($data['G']) : $flashbag->add('danger', 'La colonne G de la ligne '. $raw .' n\'est pas complétée.');
                        
                        if ($data['B']){
                            if (array_key_exists($data['B'], Prospect::getEntiteChoice())){
                                $prospect->setEntite($data['B']);
                            }
                            else{
                                $flashbag->add('danger', 'L\'entité du prospect '. $data['A'] .' n\'est pas valide.');
                            }

                        }else{
                            $flashbag->add('danger', 'La colonne B de la ligne '. $raw .' n\'est pas complétée.');
                        }
                        if ($data['H']){
                            if (array_key_exists($data['H'], Prospect::getSecteurChoice())){
                                $prospect->setSecteurActivite($data['H']);
                            }else{
                                $flashbag->add('danger', 'Le secteur du prospect '. $data['A'] .' n\'est pas valide.');
                            }
                        }else{
                            $flashbag->add('danger', 'La colonne H de la ligne '. $raw .' n\'est pas complétée.');
                        }
                        $flashbag->add('succes', 'Le prospect '. $data['A'].' a bien été enregistré.');
                        $em->getManager()->persist($prospect);
                        
                    }
                
                    // Le prospect existe, on enregistre l'employé
                    if ($data['J'] && $data['K'] && $raw >1){ // Si le nom et le prenom existe
                        $personne = $em->getRepository(Personne::class)->findOneBy(['prenom' => $data['K'],'nom' => $data['J']]);
                        if ($personne && $em->getRepository(Employe::class)->findOneBy(['personne' => $personne])){
                            $flashbag->add('error', 'L\'employé de la ligne '. $raw .' a déjà été enregistré.');
                        } else {
                            $nouveau = new Personne();
                            $nouveau->setEmailEstValide(true);
                            $nouveau->setEstAbonneNewsletter(false);
                            $nouveau->setPrenom($data['K']);
                            $nouveau->setNom($data['J']);

                            $data['L'] ? $nouveau->setMobile($data['L']) : $flashbag->add('danger', 'La colonne L de la ligne '. $raw .' n\'est pas complétée.');
                            $data['M'] ? $nouveau->setFix($data['M']) : $flashbag->add('danger', 'La colonne M de la ligne '. $raw .' n\'est pas complétée.');
                            $data['O'] ? $nouveau->setEmail($data['O']) : $flashbag->add('danger', 'La colonne O de la ligne '. $raw .' n\'est pas complétée.');
                            $data['P'] ? $nouveau->setPays($data['P']) : $flashbag->add('danger', 'La colonne P de la ligne '. $raw .' n\'est pas complétée.');
                            $data['Q'] ? $nouveau->setVille($data['Q']) : $flashbag->add('danger', 'La colonne Q de la ligne '. $raw .' n\'est pas complétée.');
                            $data['R'] ? $nouveau->setAdresse($data['R']) : $flashbag->add('danger', 'La colonne R de la ligne '. $raw .' n\'est pas complétée.');
                            $data['S'] ? $nouveau->setCodePostal($data['S']) : $flashbag->add('danger', 'La colonne S de la ligne '. $raw .' n\'est pas complétée.');
                            $em->getManager()->persist($nouveau);

                            $employe = new Employe();
                            $employe->setPersonne($nouveau);
                            $employe->setProspect($prospect);
                            $data['N'] ? $employe->setPoste($data['N']) : $flashbag->add('danger', 'La colonne N de la ligne '. $raw .' n\'est pas complétée.');
                            $flashbag->add('succes', 'L\'employé '. $data['J'].' '. $data['K'] .' a bien été enregistré.');
                            $em->getManager()->persist($employe);
                            
                        }
                    }else{
                    if ($raw >1 && ($data['J'] || $data['K'] || $data['L'] || $data['M'] || $data['N'] || $data['O'])){
                        $flashbag->add('error', 'L\'employé de la ligne '. $raw .' n\'est pas enregistré car le nom ou le prenom n\'est pas renseigné.');
                    }
                }
                    $em->getManager()->flush();
                } else{
                    if ($raw >1 && ($data['B'] ||$data['C'] || $data['D'] || $data['E'] || $data['F'] || $data['G'] || $data['H'])){
                        $flashbag->add('error', 'Le prospect de la ligne '. $raw .' n\'est pas enregistré car le nom n\'est pas renseigné.');
                    }
                }
                $raw ++;
            }
        }
}