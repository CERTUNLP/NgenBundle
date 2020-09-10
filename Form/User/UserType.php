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

namespace CertUnlp\NgenBundle\Form\User;

use CertUnlp\NgenBundle\Form\Communication\ContactType;
use CertUnlp\NgenBundle\Form\EntityType as EntityForm;
use CertUnlp\NgenBundle\Service\Listener\Form\UserTypeListener;
use FOS\UserBundle\Form\Type\RegistrationFormType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class UserType extends EntityForm
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $choices = $this->roleChoices();

        $builder
            ->add('apiKey', TextType::class, array(
                'attr' => ['disabled' => true],
            ))
            ->add('generate_api_key', CheckboxType::class, array(
                'data' => false,
                'required' => false,
                'label' => 'Generate a new apikey',
            ))
            ->add('firstname')
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
            ->addEventSubscriber(new UserTypeListener());
        $options['add_event_subscriber'] = false;
        $options['add_extra_fields'] = false;
        parent::buildForm($builder, $options);
    }

    /**
     * @return array|string[]
     */
    private function roleChoices(): array
    {
        return array(
            'ROLE_API' => 'ROLE_API',
            'ROLE_ADMIN' => 'ROLE_ADMIN',
            'ROLE_DIRECCION' => 'ROLE_DIRECCION',
            'ROLE_SUPER_ADMIN' => 'ROLE_SUPER_ADMIN');
    }

    /**
     * {@inheritDoc}
     */
    public function getParent(): ?string
    {
        return RegistrationFormType::class;
    }

    /**
     * @return string|null
     */
    public function getBlockPrefix(): ?string
    {
        return '';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return '';
    }


}
