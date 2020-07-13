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

namespace CertUnlp\NgenBundle\Form\Incident;

use CertUnlp\NgenBundle\Entity\Incident\IncidentPriority;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IncidentPriorityType extends AbstractType
{

    /*
    **
    * @param FormBuilderInterface $builder
    * @param array $options
    */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('impact', null, array(
                'placeholder' => 'Choose a impact level',
                'attr' => array('help_text' => 'If none is selected, the assigned impact will be Low.'),
            ))
            ->add('urgency', null, array(
                'placeholder' => 'Choose a urgency level',
                'attr' => array('help_text' => 'If none is selected, the assigned urgency will be Low'),
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
            ->add('id', HiddenType::class);

    }

    /**
     * @param OptionsResolver $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => IncidentPriority::class,
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
