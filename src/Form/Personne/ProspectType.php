<?php

/*
 * This file is part of the Incipio package.
 *
 * (c) Florian Lefevre
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Form\Personne;

use App\Entity\Personne\Prospect;
use Genemu\Bundle\FormBundle\Form\JQuery\Type\Select2EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Personne\SecteurActivite;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class ProspectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class)
            ->add(
                'entite',
                ChoiceType::class,
                ['choices' => array_flip(Prospect::getEntiteChoice()), 'required' => false]
            )
            ->add('adresse', TextareaType::class, ['required' => false])
            ->add('codepostal', TextType::class, ['required' => false])
            ->add('ville', TextType::class, ['required' => false])
            ->add('pays', TextType::class, ['required' => false])
            ->add('secteurActivite', Select2EntityType::class,
            [
                'class' => SecteurActivite::class,
                'choice_label' => 'intitule',
                'required' => false,
            ]
            )
            ->add('mail', EmailType::class,
                ['required' => false]
            );
    }

    public function getBlockPrefix()
    {
        return 'suivi_prospecttype';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Prospect::class,
        ]);
    }
}
