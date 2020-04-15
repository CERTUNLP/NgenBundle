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

use FOS\UserBundle\Form\Type\RegistrationFormType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class UserType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $choices = $this->roleChoices();

        $builder->add('firstname')
            ->add('lastname')
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'options' => array('translation_domain' => 'FOSUserBundle'),
                'first_options' => array('label' => 'form.password'),
                'second_options' => array('label' => 'form.password_confirmation'),
                'invalid_message' => 'fos_user.password.mismatch',
            ))
            ->add('roles', ChoiceType::class, array(
                'label' => 'Roles',
                'choices' => $choices,
                'expanded' => true,
                'multiple' => true,
                'data' => $builder->getData() ? $builder->getData()->getRoles() : []
            ))
            ->add('contacts', CollectionType::class,
                array(
                    'label' => 'Contacts',
                    'entry_options' => array('label' => false),
                    'entry_type' => ContactType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'prototype' => true,
                    'required' => true,
                    'by_reference' => false,
                    'delete_empty' => true,
                    'attr' => array(
                        'class' => 'user-contacts',
                    ),
                ))
            ->add('save', SubmitType::class, array(
                'attr' => array('class' => 'save btn btn-primary btn-block', 'data-style' => 'slide-down')))
            ->addEventListener(
                FormEvents::PRE_SET_DATA,
                array($this, 'onPreSetData')
            );
    }

    private function roleChoices()
    {
        return array(
            'ROLE_API' => 'ROLE_API',
            'ROLE_ADMIN' => 'ROLE_ADMIN',
            'ROLE_DIRECCION' => 'ROLE_DIRECCION',
            'ROLE_SUPER_ADMIN' => 'ROLE_SUPER_ADMIN');
    }

    public function getParent()
    {
        return RegistrationFormType::class;

        // Or for Symfony < 2.8
        // return 'fos_user_registration';
    }

    public function getBlockPrefix()
    {
        return '';
    }

    // For Symfony 2.x
    public function getName()
    {
        return '';
    }

    public function onPreSetData(FormEvent $event)
    {

        // get the form
        $form = $event->getForm();


        $data = $event->getData();

        // disable field if it has been populated with a client already
        if ($data) {
            $form
                ->add('username', null, array(
                    'required' => true,
                    'read_only' => 'true',
                ))
                ->add('plainPassword', RepeatedType::class, array(
                    'required' => false,
                    'type' => PasswordType::class,
                    'options' => array('translation_domain' => 'FOSUserBundle'),
                    'first_options' => array('label' => 'form.password'),
                    'second_options' => array('label' => 'form.password_confirmation'),
                    'invalid_message' => 'fos_user.password.mismatch',
                ));
        }

    }


}
