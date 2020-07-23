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

use CertUnlp\NgenBundle\Service\Listener\Form\EntityTypeListener;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class EntityType extends AbstractType
{

    /**
     * @var EntityTypeListener
     */
    private $entity_type_listener;

    public function __construct(EntityTypeListener $entity_type_listener)
    {
        $this->entity_type_listener = $entity_type_listener;
    }


    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('active', CheckboxType::class)
            ->add('force_edit', CheckboxType::class,
                array('data' => false,
                    'mapped' => false,
                    'label_attr' => array('class' => 'alert alert-warning'),
                    'attr' => array('align_with_widget' => true, 'help_text' => 'If it set to true the network will be edited and not replaced.(this can harm the network history)'),
                    'required' => false,
                    'label' => 'Force edit'))
            ->add('save', SubmitType::class, array('attr' =>
                array('class' => 'save btn btn-primary btn-block', 'data-style' => 'slide-down'),
            ))
            ->addEventSubscriber($this->entity_type_listener);
    }

    /**
     * @param OptionsResolver $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'frontend' => false,
        ));
    }
}
