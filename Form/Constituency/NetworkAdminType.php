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

namespace CertUnlp\NgenBundle\Form\Constituency;

use CertUnlp\NgenBundle\Entity\Constituency\NetworkAdmin;
use CertUnlp\NgenBundle\Form\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NetworkAdminType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('name', null, array(
                'required' => true,
            ))
            ->add('id', HiddenType::class, array(
                'required' => false,
            ))
            ->add('contacts', CollectionType::class,
                array(
                    'label' => 'Contacts',
                    'entry_options' => array('label' => false),
                    'entry_type' => ContactType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'prototype' => true,
                    'required' => false,
                    'by_reference' => false,
                    'delete_empty' => true,
                    'attr' => array(
                        'class' => 'admin-contacts',
                    ),
                ));
    }

    /**
     * @param OptionsResolver $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => NetworkAdmin::class,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return '';
    }

    /**
     * {@inheritDoc}
     */
    public function getParent(): ?string
    {
        return EntityType::class;
    }
}
