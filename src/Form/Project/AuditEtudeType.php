<?php

/*
 * This file is part of the Incipio package.
 *
 * (c) Florian Lefevre
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Form\Project;

use App\Entity\Project\Etude;
use Genemu\Bundle\FormBundle\Form\JQuery\Type\DateType as GenemuDateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AuditEtudeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'stateID',
            ChoiceType::class,
            ['choices' => array_flip(Etude::ETUDE_STATE_ARRAY),
             'translation_domain' => 'project',
             'label' => 'Etat de l\'Étudee',
             'required' => true,
            ]
        )
            ->add(
                'auditDate',
                GenemuDateType::class,
                ['label' => 'Date de naissance (jj/mm/aaaa)', 'widget' => 'single_text', 'format' => 'dd/MM/yyyy',
                 'required' => false,
                ])
            ->add(
                'auditType',
                AuditType::class,
                ['label' => 'Type d\'audit', 'required' => true, 'choice_label' => function ($var) {
                    return $var;
                },
                ]
            );
    }

    public function getBlockPrefix()
    {
        return 'project_suivietudetype';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Etude::class,
        ]);
    }
}
