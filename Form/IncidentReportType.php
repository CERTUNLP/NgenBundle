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
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class IncidentReportType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
                ->add('lang', ChoiceType::class, array(
                    'choices' => array(
                        'Spanish' => 'es',
                        'English' => 'en',
                    ),
                    'required' => true,
                    'choices_as_values' => true
                ))
                ->add('type', EntityType::class, array(
                    'class' => 'CertUnlpNgenBundle:IncidentType',
                    'required' => true,
                    'description' => "The administrator responsible for the network",
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('it')
                                ->where('it.isActive = TRUE')
                                ->orderBy('it.name', 'ASC');
                    }
                ))
                ->add('problem', null, array(
                    'required' => true,
                ))
                ->add('derivated_problem', null, array(
                    'required' => true,
                ))
                ->add('verification', null, array(
                    'required' => true,
                ))
                ->add('recomendations', null, array(
                    'required' => true,
                ))
                ->add('more_information', null, array(
                    'required' => true,
                ))
                ->add('save', 'submit', array('attr' =>
                    array('class' => 'save ladda-button btn-lg btn-block', 'data-style' => "slide-down"),
        ));
        


//        if ($builder->getData()) {
//            if (!$builder->getData()->getIsActive()) {
//                $builder
//                        ->add('reactivate', 'checkbox', array('data' => false, 'mapped' => false, 'label_attr' => array('class' => 'alert alert-warning'), 'attr' => array('align_with_widget' => true, 'help_text' => 'If it set to true the network will be reactivated.'), 'required' => false, 'label' => 'Reactivate?'));
//            }
//            $builder
//                    ->add('force_edit', 'checkbox', array('data' => false, 'mapped' => false, 'label_attr' => array('class' => 'alert alert-warning'), 'attr' => array('align_with_widget' => true, 'help_text' => 'If it set to true the network will be edited and not replaced.(this can harm the network history)'), 'required' => false, 'label' => 'Force edit'));
//        }
//
//
//        $builder->add('save', 'submit', array('attr' =>
//            array('class' => 'save ladda-button btn-lg btn-block', 'data-style' => "slide-down"),
//        ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'CertUnlp\NgenBundle\Entity\IncidentReport',
            'csrf_protection' => false,
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return '';
    }

}
