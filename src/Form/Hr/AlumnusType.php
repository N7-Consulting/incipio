<?php

namespace App\Form\Hr;

use App\Entity\Hr\Alumnus;
use App\Entity\Personne\Membre;
use Genemu\Bundle\FormBundle\Form\JQuery\Type\Select2EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AlumnusType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('commentaire', TextareaType::class, ['required' => false, 'label' => 'Commentaire', 'attr' => ['cols' => '100%', 'rows' => 4]])
            ->add('lienLinkedIn', TextareaType::class,
                ['required' => false, 'label' => 'Lien LinkedIn', 'attr' => ['cols' => '100%', 'rows' => 2]]
            )
            ->add('secteurActuel', ChoiceType::class,
            ['choices' => array_flip(Alumnus::getSecteurChoice()), 'required' => false]
            )
            ->add('posteActuel', TextareaType::class,
                ['required' => false, 'label' => 'Poste en entreprise actuel', 'attr' => ['cols' => '100%', 'rows' => 2]]
            )
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Alumnus::class,
        ]);
    }
}
