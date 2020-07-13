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

use CertUnlp\NgenBundle\Entity\Incident\Incident;
use CertUnlp\NgenBundle\Entity\Incident\IncidentFeed;
use CertUnlp\NgenBundle\Entity\Incident\IncidentPriority;
use CertUnlp\NgenBundle\Entity\Incident\IncidentTlp;
use CertUnlp\NgenBundle\Entity\Incident\State\IncidentState;
use CertUnlp\NgenBundle\Entity\User;
use Exception;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IncidentSearchType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * @throws Exception
     */

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', null, array(
                'label' => false,
                'required' => false,
                'placeholder' => 'All',
                'choice_value' => 'name',
                'attr' => array('class' => 'select-filter', 'search' => 'slug')
            ))
            ->add('feed', EntityType::class, array(
                'class' => IncidentFeed::class,
                'placeholder' => 'All',
                'required' => false,
                'label' => false,
                'choice_value' => 'name',
                'attr' => array('class' => 'select-filter', 'search' => 'slug')
            ))
            ->add('address', null, array(
                'required' => false,
                'label' => false,
                'empty_data' => 'google',
                'mapped' => false,
                'attr' => array('class' => 'select-filter', 'search' => json_encode([]), 'index' => 'origin')
            ))
            ->add('dates', null, array(
                'required' => false,
                'label' => false,
                'mapped' => false,
                'attr' => array('class' => 'select-filter', 'index' => 'date', 'size' => 11),
            ))
            ->add('updatesAt', null, array(
                'required' => false,
                'label' => false,
                'mapped' => false,
                'attr' => array('class' => 'select-filter', 'index' => 'updatedAt', 'size' => 11),
            ))
            ->add('state', EntityType::class, array(
                'label' => false,
                'required' => false,
                'class' => IncidentState::class,
                'placeholder' => 'All',
                'choice_value' => 'name',
                'attr' => array('class' => 'select-filter', 'search' => 'slug')
            ))
            ->add('tlp', EntityType::class, array(
                'label' => false,
                'required' => false,
                'class' => IncidentTlp::class,
                'placeholder' => 'All',
                'choice_value' => 'name',
                'attr' => array('class' => 'select-filter', 'search' => 'slug')
            ))
            ->add('reporter', EntityType::class, array(
                'label' => false,
                'required' => false,
                'class' => User::class,
                'placeholder' => 'All',
                'choice_value' => 'name',
                'attr' => array('class' => 'select-filter', 'search' => 'id')
            ))
            ->add('assigned', EntityType::class, array(
                'label' => false,
                'required' => false,
                'class' => User::class,
                'placeholder' => 'All',
                'choice_value' => 'name',
                'attr' => array('class' => 'select-filter', 'search' => 'id')
            ))
            ->add('ltdCount', null, array(
                'label' => false,
                'required' => false,
                'empty_data' => '',
                'attr' => array('class' => 'select-filter')
            ))
            ->add('priority', EntityType::class, array(
                'label' => false,
                'required' => false,
                'class' => IncidentPriority::class,
                'choice_value' => 'name',
                'placeholder' => 'All',
                'attr' => array('class' => 'select-filter', 'search' => 'name')
            ));

    }

    /**
     * @param OptionsResolver $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Incident::class,
        ));
    }

    /**
     * @return string
     */
    public function getName(): string
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
