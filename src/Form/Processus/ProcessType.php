<?php

/*
 * This file is part of the Incipio package.
 *
 * (c) Florian Lefevre
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Form\Processus;

use App\Entity\Processus\Processus;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

use App\Entity\Publish\Document;

class ProcessType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, ['required' => true])
            ->add('pilote', TextType::class, ['required' => true])
            
            // ->add('template', FileType::class, [
            //     'required' => true,
            //     'label' => 'dashboard.template',
            //     'translation_domain' => 'dashboard',
            // ])
            ;
    }

    public function getBlockPrefix()
    {
        return 'processus_processtype';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
             'data_class' => Processus::class,
        ]);
    }
}
