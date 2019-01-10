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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class IncidentStateType extends AbstractType
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
            ->add('mailReporter', ChoiceType::class, array(
                'attr' => array('align_with_widget' => true),
                'required' => true,
                'label' => 'Send mail to reporter(if available)',
                'description' => 'Send a mail report to the reporter.',
                'choices'  => array(
                    'none'=> "Dont use it",
                    'critical' => "Only critical",
                    'all' => "All",

                ),
            ))
            ->add('mailAssigned', ChoiceType::class, array(
                'attr' => array('align_with_widget' => true),
                'required' => true,
                'label' => 'Send mail to the one who has it assigned (if available)',
                'description' => 'Send a mail report to the one who has it assigned.',
                'choices'  => array(
                    'none'=> "Dont use it",
                    'critical' => "Only critical",
                    'all' => "All",

                ),
            ))
            ->add('mailAdmin', ChoiceType::class, array(
                'mapped' => true,
                'attr' => array('align_with_widget' => true),
                'required' => true,
                'label' => 'Send mail to Admin Responsable(if available)',
                'description' => 'Send a mail report to the host administrator.',
                'choices'  => array(
                    'none'=> "Dont use it",
                    'critical' => "Only critical",
                    'all' => "All",

                ),
            ))
            ->add('mailTeam', ChoiceType::class, array(
                'mapped' => true,
                'attr' => array('align_with_widget' => true),
                'required' => true,
                'label' => 'Send mail to the team',
                'description' => 'Send a mail report to the team.',
                'choices'  => array(
                    'none'=> "Dont use it",
                    'critical' => "Only critical",
                    'all' => "All",

                ),
            ));

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
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CertUnlp\NgenBundle\Entity\Incident\IncidentState',
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
