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

use CertUnlp\NgenBundle\Entity\Contact\ContactCase;
use CertUnlp\NgenBundle\Entity\Incident\State\Edge\StateEdge;
use CertUnlp\NgenBundle\Entity\Incident\State\IncidentState;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StateEdgeType extends AbstractType
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
            ->add('oldState', EntityType::class, array(
                'class' => IncidentState::class,
                'attr' => array('align_with_widget' => true),
                'required' => true,
                'label' => 'Send mail to reporter(if available)',
                'description' => 'Send a mail report to the reporter.',
            ))
            ->add('newState', EntityType::class, array(
                'class' => IncidentState::class,
                'attr' => array('align_with_widget' => true),
                'required' => true,
                'label' => 'Send mail to the one who has it assigned (if available)',
                'description' => 'Send a mail report to the one who has it assigned.',
            ))
            ->add('isActive', EntityType::class, array(
                'class' => ContactCase::class,
                'attr' => array('align_with_widget' => true),
                'required' => true,
                'label' => 'Send mail to Admin Responsable(if available)',
                'description' => 'Send a mail report to the host administrator.',
            ))
            ->add('save', SubmitType::class, array('attr' =>
                array('class' => 'save ladda-button btn-lg btn-block', 'data-style' => 'slide-down'),
            ));
    }

    /**
     * @param OptionsResolver $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => StateEdge::class,
            'csrf_protection' => false,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return '';
    }

}
