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

use CertUnlp\NgenBundle\Entity\Network\Host\Host;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class HostType extends AbstractType
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
            ->add('address', null, array(
                'required' => true,
                'attr' => array('help_text', 'placeholder' => 'IPV(4|6)/mask or domain'),
                'label' => 'Address',
                'description' => 'The network ip and mask',
            ))
            ->add('save', SubmitType::class, array(
                'attr' => array('class' => 'save ladda-button btn-lg btn-block', 'data-style' => 'slide-down'),
//                    'description' => "Evidence file that will be attached to the report "
            ));

    }

    /**
     * @param OptionsResolverInterface $resolver
     * @return void
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Host::class,
            'csrf_protection' => false,
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
