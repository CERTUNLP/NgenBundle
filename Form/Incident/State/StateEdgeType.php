<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Form\Incident\State;

use CertUnlp\NgenBundle\Entity\Communication\Contact\ContactCase;
use CertUnlp\NgenBundle\Entity\Incident\State\Edge\StateEdge;
use CertUnlp\NgenBundle\Entity\Incident\State\IncidentState;
use CertUnlp\NgenBundle\Form\EntityType as EntityForm;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StateEdgeType extends EntityForm
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, array(
                'required' => true,
            ))
            ->add('oldState', EntityType::class, array(
                'class' => IncidentState::class,
                'attr' => array('align_with_widget' => true),
                'required' => true,
                'label' => 'Send mail to reporter(if available)',
            ))
            ->add('newState', EntityType::class, array(
                'class' => IncidentState::class,
                'attr' => array('align_with_widget' => true),
                'required' => true,
                'label' => 'Send mail to the one who has it assigned (if available)',
            ))
            ->add('active', EntityType::class, array(
                'class' => ContactCase::class,
                'attr' => array('align_with_widget' => true),
                'required' => true,
                'label' => 'Send mail to Admin Responsable(if available)',
            ));
        parent::buildForm($builder, $options);
    }

    /**
     * @param OptionsResolver $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => StateEdge::class,
        ));
    }


}
