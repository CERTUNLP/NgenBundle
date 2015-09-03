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

class IncidentType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('type', null, array('empty_value' => 'Choose an incident type', 'required' => true))
                ->add('hostAddress', null, array('attr' => array('maxlength' => '300', 'help_text' => 'Add more than one address separating them with a comma')))
                ->add('reporter', null, array('empty_value' => 'Choose a reporter', 'attr' => array('help_text' => 'If none is selected, the reporter will be the logged user')))
                ->add('feed', 'entity', array('class' => 'CertUnlpNgenBundle:IncidentFeed', 'required' => true))
                ->add('state', null, array('empty_value' => 'Choose an incident state', 'attr' => array('help_text' => 'If none is selected, the state will be \'open\' ')))
                ->add('date', 'date', array('required' => false, 'html5' => true, 'widget' => 'single_text', 'input' => 'datetime', 'attr' => array('help_text' => 'If no date is selected, the date will be today')))
                ->add('sendReport', 'checkbox', array('data' => true, 'mapped' => true, 'attr' => array('align_with_widget' => true), 'required' => false, 'label' => 'Send mail report(if available)'))
                ->add('editReport', 'button', array('label' => 'Edit the report', 'attr' =>
                    array('class' => 'save ladda-button btn btn-primary', 'data-style' => "slide-down")))
                ->add('reportEdit', 'textarea', array('required' => false, 'label' => 'Edit the report',
                    'label_attr' => array('class' => 'hidden'),
                    'attr' => array(
                        'class' => 'hidden',
                        'data-theme' => 'simple',
                    )
                ))
                ->add('evidence_file', 'file', array('label' => 'Report attachment', 'required' => false))
                ->add('save', 'submit', array('attr' =>
                    array('class' => 'save ladda-button btn-lg btn-block', 'data-style' => "slide-down"),
        ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'CertUnlp\NgenBundle\Entity\Incident'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return '';
    }

}
