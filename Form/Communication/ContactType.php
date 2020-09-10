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

namespace CertUnlp\NgenBundle\Form\Communication;

use CertUnlp\NgenBundle\Entity\Communication\Contact\Contact;
use CertUnlp\NgenBundle\Entity\Communication\Contact\ContactCase;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('name', TextType::class, array(
                'required' => true,
                'attr' => array('placeholder' => 'Description'),
            ))
            ->add('username', TextType::class, array(
                'required' => true,
                'attr' => array('placeholder' => 'Email/Phone Number/Telegram chat'),

            ))
            ->add('encryptionKey', TextType::class, array(
                'required' => false,
                'attr' => array('placeholder' => 'GPG public key'),

            ))
            ->add('contact_case', EntityType::class, array(
                'required' => true,
                'class' => ContactCase::class
            ))
            ->add('network_admin', HiddenType::class, array(
                'required' => true,
            ))
            ->add('contact_type', ChoiceType::class, array(
                'required' => true,
                'choices' => array(
                    'Mail' => 'mail',
                    'Telegram' => 'telegram',
                    'Phone' => 'phone',

                ),
                'choices_as_values' => true,
            ));

    }

    /**
     * {@inheritDoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => Contact::class,
        ));
    }

    /**
     * {@inheritDoc}
     */
    public function getBlockPrefix(): ?string
    {
        return 'ContactType';
    }

}
