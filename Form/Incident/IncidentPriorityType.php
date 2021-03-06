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

use CertUnlp\NgenBundle\Entity\Incident\IncidentImpact;
use CertUnlp\NgenBundle\Entity\Incident\IncidentPriority;
use CertUnlp\NgenBundle\Entity\Incident\IncidentUrgency;
use CertUnlp\NgenBundle\Form\EntityType as EntityForm;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IncidentPriorityType extends EntityForm
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('impact', EntityType::class, array(
                'class' => IncidentImpact::class,
                'placeholder' => 'Choose a impact level',
                'attr' => array('help_text' => 'If none is selected, the assigned impact will be Low.'),
            ))
            ->add('urgency', EntityType::class, array(
                'class' => IncidentUrgency::class,
                'placeholder' => 'Choose a urgency level',
                'attr' => array('help_text' => 'If none is selected, the assigned urgency will be Low'),
            ))
            ->add('name', TextType::class, array(
                'required' => true,
            ))
            ->add('code', IntegerType::class, array(
                'required' => true,
            ))
            ->add('solveTime', IntegerType::class, array(
                'required' => true,
            ))
            ->add('unsolveTime', IntegerType::class, array(
                'required' => true,
            ))
            ->add('response_time', IntegerType::class, array(
                'required' => true,
            ))
            ->add('unresponse_time', IntegerType::class, array(
                'required' => true,
            ))
            ->add('id', HiddenType::class);
        parent::buildForm($builder, $options);

    }

    /**
     * @param OptionsResolver $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);
        $resolver->setDefaults(array(
            'data_class' => IncidentPriority::class,
        ));
    }


}
