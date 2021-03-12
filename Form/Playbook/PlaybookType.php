<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

 /**
 * Description of PlaybookType
 *
 * @author asanchezg
 */

namespace CertUnlp\NgenBundle\Form\Playbook;

use CertUnlp\NgenBundle\Entity\Playbook\Playbook;
use CertUnlp\NgenBundle\Form\EntityType as EntityForm;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use CertUnlp\NgenBundle\Entity\Incident\IncidentType as IncidentTypeEntity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use CertUnlp\NgenBundle\Form\Playbook\PhaseType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PlaybookType extends EntityForm
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('type', EntityType::class, array(
            'class' => IncidentTypeEntity::class,
            'placeholder' => 'Choose an incident type',
            'required' => true,
            'attr' => array('class' => 'incidentFilter'),
        ))
        ->add('name', TextType::class, array(
            'required' => true,
        ))
        ->add('description', TextType::class, array(
           'required' => true,
        ))
        ->add('phases', CollectionType::class,
                array(
                    'label' => 'Phases',
                    'entry_options' => array('label' => false),
                    'entry_type' => PhaseType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'prototype' => true,
                    'required' => false,
                    'by_reference' => false,
                    'delete_empty' => true,
                    'attr' => array(
                        'class' => 'playbook-phases',
                    ),
                ))
        ->add('save', SubmitType::class, ['label' => 'Save Playbook']);
        parent::buildForm($builder, $options);
    }

    /**
     * @param OptionsResolver $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults(array(
            'data_class' => Playbook::class,
        ));
    }
}
