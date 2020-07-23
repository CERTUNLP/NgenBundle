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

use CertUnlp\NgenBundle\Entity\Incident\IncidentReport;
use CertUnlp\NgenBundle\Entity\Incident\IncidentType;
use CertUnlp\NgenBundle\Form\EntityType as EntityForm;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IncidentReportType extends EntityForm
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

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
                'class' => IncidentType::class,
                'required' => true,
            ))
            ->add('problem', TextType::class, array(
                'required' => true,
            ))
            ->add('derivated_problem', TextType::class, array(
                'required' => false,
            ))
            ->add('verification', TextType::class, array(
                'required' => false,
            ))
            ->add('recomendations', TextType::class, array(
                'required' => false,
            ))
            ->add('more_information', TextType::class, array(
                'required' => false,
            ));
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
            'data_class' => IncidentReport::class,
        ));
    }
}
