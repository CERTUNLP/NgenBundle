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

use CertUnlp\NgenBundle\Entity\Incident\IncidentPriority;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class IncidentPriorityType extends AbstractType
{
    public function __construct($doctrine = null)
    {
        $this->doctrine = $doctrine;
    }

    /*
    **
    * @param FormBuilderInterface $builder
    * @param array $options
    */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('impact', null, array(
                'empty_value' => 'Choose a impact level',
                'attr' => array('help_text' => 'If none is selected, the assigned impact will be Low.'),
                'description' => 'If none is selected, the assigned impact will be Low',
            ))
            ->add('urgency', null, array(
                'empty_value' => 'Choose a urgency level',
                'attr' => array('help_text' => 'If none is selected, the assigned urgency will be Low'),
                'description' => 'If none is selected, the assigned urgency will be Low',
            ))
            ->add('name', null, array(
                'required' => true,
            ))
            ->add('code', NumberType::class, array(
                'required' => true,
            ))
            ->add('resolution_time', NumberType::class, array(
                'required' => true,
            ))
            ->add('unresolution_time', NumberType::class, array(
                'required' => true,
            ))
            ->add('response_time', NumberType::class, array(
                'required' => true,
            ))
            ->add('unresponse_time', NumberType::class, array(
                'required' => true,
            ))
            ->add('save', SubmitType::class, array(
                'attr' => array('class' => 'save ladda-button btn-lg btn-block', 'data-style' => 'slide-down'),
            ));

    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => IncidentPriority::class,
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
