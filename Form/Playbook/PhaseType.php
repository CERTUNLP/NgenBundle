<?php
/**
 * This file is part of the Ngen - CSIRT Incident Report System.
 *   (c) CERT UNLP <support@cert.unlp.edu.ar>
 *  This source file is subject to the GPL v3.0 license that is bundled
 *  with this source code in the file LICENSE.
 */

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Form\Playbook;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use CertUnlp\NgenBundle\Entity\Playbook\Phase;
use CertUnlp\NgenBundle\Entity\Playbook\Task;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use CertUnlp\NgenBundle\Form\Playbook\TaskType;

class PhaseType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, array(
                'label' => 'Phase name',
                'required' => true,
                'attr' => array('placeholder' => 'Phase name'),
            ))
            ->add('description', TextType::class, array(
                'label' => 'Phase description',
                'required' => true,
                'attr' => array('placeholder' => 'Phase description'),
            ))
            ->add('tasks',CollectionType::class,
                array(
                    'label' => 'Tasks',
                    'entry_options' => array('label' => false),
                    'entry_type' => TaskType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'prototype' => true,
                    'prototype_name' => '__task__',
                    'required' => false,
                    'by_reference' => false,
                    'delete_empty' => true,
                    'attr' => array(
                        'class' => 'phase-tasks',
                    ),
                ));
    }

    /**
     * {@inheritDoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => Phase::class,
        ));
     
    }

    /**
     * {@inheritDoc}
     */
    public function getBlockPrefix(): ?string
    {
        return 'PhaseType';
    }
}
