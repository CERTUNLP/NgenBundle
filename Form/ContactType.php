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

use CertUnlp\NgenBundle\Entity\Contact\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContactType extends AbstractType
{
    public function getBlockPrefix()
    {
        return 'ContactType';
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('name', null, array(
                'required' => false,
                'attr' => array('placeholder' => 'Description'),
            ))
            ->add('username', null, array(
                'required' => false,
                'attr' => array('placeholder' => 'Email/Phone Number/Telegram chat'),

            ))
            ->add('encryptionKey', null, array(
                'required' => false,
                'attr' => array('placeholder' => 'GPG public key'),

            ))
            ->add('contact_case', ChoiceType::class, array(
                'label'=> 'When to use it?',
                'attr' => array('placeholder' => 'When to use it?'),
                'choices'  => array(
                'none'=> "Dont use it",
                'critical' => "Only critical",
                'all' => "All",

            ),
                // *this line is important*
            'choices_as_values' => true,
            ))
            ->add('network_admin', HiddenType::class, array(
                'required' => false,
            ))
            ->add('contact_type', ChoiceType::class, array(
                    'choices'  => array(
                    'Mail' => "mail",
                    'Telegram'=> "telegram",
                    'Phone' => "phone",

                ),
                // *this line is important*
                'choices_as_values' => true,
            ));

        if ($builder->getData()) {
            if (!$builder->getData()->getIsActive()) {
                $builder
                    ->add('reactivate', CheckboxType::class, array('data' => false, 'mapped' => false, 'label_attr' => array('class' => 'alert alert-warning'), 'attr' => array('align_with_widget' => true, 'help_text' => 'If it set to true the network will be reactivated.'), 'required' => false, 'label' => 'Reactivate?'));
            }
            $builder
                ->add('force_edit', CheckboxType::class, array('data' => false, 'mapped' => false, 'label_attr' => array('class' => 'alert alert-warning'), 'attr' => array('align_with_widget' => true, 'help_text' => 'If it set to true the network will be edited and not replaced.(this can harm the network history)'), 'required' => false, 'label' => 'Force edit'));
        }

        $builder->add('save', SubmitType::class, array('attr' =>
            array('class' => 'save ladda-button btn-lg btn-block', 'data-style' => 'slide-down'),
        ));

        $builder->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) {
            $admin = $event->getData();
            $form = $event->getForm();
            // check if the Product object is "new"
            // If no data is passed to the form, the data is "null".
            // This should be considered a new "Product"
            //if ($admin) {
              //  $form->get('contacts')->setData('1');
                //print_r($setData($network->getId());
            //}
        });
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Contact::class,
            'csrf_protection' => false,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return '';
    }

}
