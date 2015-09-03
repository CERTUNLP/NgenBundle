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

class NetworkType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
                ->add('ip', null)
                ->add('ipMask', null)
                ->add('networkAdmin', null, array('required' => true, 'empty_value' => 'Choose an admin', 'attr' => array('help_text' => 'This will be the network admin'),
                    'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('na')
                        ->where('na.isActive = TRUE')
                        ->orderBy('na.name', 'ASC');
            }))
                ->add('academicUnit', null, array('required' => true, 'empty_value' => 'Choose a unit', 'attr' => array('help_text' => 'The unit to which the network belongs'),
                    'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('au')
                        ->orderBy('au.name', 'ASC');
            }));

        if ($builder->getData()) {
            if (!$builder->getData()->getIsActive()) {
                $builder
                        ->add('reactivate', 'checkbox', array('data' => false, 'mapped' => false, 'label_attr' => array('class' => 'alert alert-warning'), 'attr' => array('align_with_widget' => true, 'help_text' => 'If it set to true the network will be reactivated.'), 'required' => false, 'label' => 'Reactivate?'));
            }
            $builder
                    ->add('force_edit', 'checkbox', array('data' => false, 'mapped' => false, 'label_attr' => array('class' => 'alert alert-warning'), 'attr' => array('align_with_widget' => true, 'help_text' => 'If it set to true the network will be edited and not replaced.(this can harm the network history)'), 'required' => false, 'label' => 'Force edit'));
        }

        $builder->add('save', 'submit', array('attr' =>
            array('class' => 'save ladda-button btn-lg btn-block', 'data-style' => "slide-down"),
        ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'CertUnlp\NgenBundle\Entity\Network'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return '';
    }

}
