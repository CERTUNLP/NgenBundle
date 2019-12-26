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

use CertUnlp\NgenBundle\Entity\Incident\Incident;
use CertUnlp\NgenBundle\Entity\Incident\IncidentFeed;
use CertUnlp\NgenBundle\Entity\Incident\IncidentPriority;
use CertUnlp\NgenBundle\Entity\Incident\IncidentTlp;
use CertUnlp\NgenBundle\Entity\Incident\State\IncidentState;
use CertUnlp\NgenBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class IncidentSearchType extends AbstractType
{
    private $userLogged;
    private $doctrine;

    public function __construct(EntityManager $doctrine = null, int $userLogged = null)
    {
        $this->doctrine = $doctrine;
        $this->userLogged = $userLogged;
    }


    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * @throws \Exception
     */

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', null, array(
                'label' => false,
                'required' => false,
                'empty_value' => 'All',
                'choice_value' => 'name',
                'attr' => array('class' => 'select-filter', 'search' => 'slug')
            ))
            ->add('feed', EntityType::class, array(
                'class' => IncidentFeed::class,
                'empty_value' => 'All',
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
                'empty_value' => 'All',
                'choice_value' => 'name',
                'attr' => array('class' => 'select-filter', 'search' => 'slug')
            ))
            ->add('tlp', EntityType::class, array(
                'label' => false,
                'required' => false,
                'class' => IncidentTlp::class,
                'empty_value' => 'All',
                'choice_value' => 'name',
                'attr' => array('class' => 'select-filter', 'search' => 'slug')
            ))
            ->add('reporter', EntityType::class, array(
                'label' => false,
                'required' => false,
                'class' => User::class,
                'empty_value' => 'All',
                'choice_value' => 'name',
                'attr' => array('class' => 'select-filter', 'search' => 'id')
            ))
            ->add('assigned', EntityType::class, array(
                'label' => false,
                'required' => false,
                'class' => User::class,
                'empty_value' => 'All',
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
                'empty_value' => 'All',
                'attr' => array('class' => 'select-filter', 'search' => 'name')
            ));

    }

    /**
     * @param OptionsResolverInterface $resolver
     * @return void
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Incident::class,
            'csrf_protection' => true,
        ));
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return '';
    }


}
