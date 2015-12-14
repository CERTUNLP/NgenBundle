<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class NetworkAdminType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
                ->add('name', null, array(
                    'required' => true,
                ))
                ->add('email', null, array(
                    'required' => true,
                ))
                ->add('isActive', null, array(
                    'required' => false,
                    'attr' => array(
                        'align_with_widget' => true,
                    ),
        ));

        $builder->add('save', 'submit', array('attr' =>
            array('class' => 'save ladda-button btn-lg btn-block', 'data-style' => "slide-down"),
        ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'CertUnlp\NgenBundle\Entity\NetworkAdmin'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return '';
    }

}
