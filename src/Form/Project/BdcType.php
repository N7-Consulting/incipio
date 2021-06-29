<?php

namespace App\Form\Project;

use App\Entity\Hr\Competence;
use App\Entity\Personne\Personne;
use App\Entity\Project\Etude;
use App\Repository\Personne\PersonneRepository;
use Genemu\Bundle\FormBundle\Form\JQuery\Type\Select2EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BdcType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->add('bdc', SubBdcType::class, ['label' => ' ', 'prospect' => $options['prospect']])
      ->add('acompte', CheckboxType::class, ['label' => 'suivi.acompte','translation_domain' => 'project', 'required' => false])
      ->add('pourcentageAcompte', PercentType::class, ['label' => 'Pourcentage acompte', 'required' => false])
      ->add(
        'suiveur',
        Select2EntityType::class,
        [
          'label' => 'Suiveur de projet',
          'class' => Personne::class,
          'choice_label' => 'prenomNom',
          'query_builder' => function (PersonneRepository $pr) {
            return $pr->getByMandatNonNulQueryBuilder();
          },
          'required' => false,
        ]
      )
      ->add('fraisDossier', IntegerType::class, ['label' => 'Frais de dossier', 'required' => false])
      ->add(
        'presentationProjet',
        TextareaType::class,
        [
          'label' => 'Présentation du projet',
          'required' => false,
          'attr' => ['cols' => '100%', 'rows' => 5],
        ]
      )
      ->add(
        'descriptionPrestation',
        TextareaType::class,
        [
          'label' => 'Description de la prestation proposée',
          'required' => false,
          'attr' => [
            'title' => "La phrase commence par 'N7 Consulting réalisera, pour le compte du Client,
                    une étude consistant en'. Il faut la continuer en décrivant la prestation proposée.
                    Le début de la phrase est déjà généré.",
            'cols' => '100%',
            'rows' => 5,
          ],
        ]
      )
      ->add('competences', Select2EntityType::class, [
        'class' => Competence::class,
        'by_reference' => false,
        'multiple' => true,
      ]);
  }

  public function getBlockPrefix()
  {
    return 'project_bdctype';
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
      'data_class' => Etude::class,
      'prospect' => '',
    ]);
  }
}
