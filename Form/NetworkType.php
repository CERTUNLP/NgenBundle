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

use CertUnlp\NgenBundle\Entity\Network\Network;
use CertUnlp\NgenBundle\Entity\Network\NetworkAdmin;
use CertUnlp\NgenBundle\Entity\Network\NetworkEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

class NetworkType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
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
            ->add('type', ChoiceType::class, array(
                'mapped' => false,
                'required' => true,
                'choices' => array(
                    'Internal' => 'internal',
                    'External' => 'external',
                ),
                'choices_as_values' => true,
            ))
            ->add('networkEntity', Select2EntityType::class, [
                'remote_route' => 'cert_unlp_ngen_network_entity_search_autocomplete',
                'class' => NetworkEntity::class,
                'minimum_input_length' => 3,
                'page_limit' => 10,
                'placeholder' => 'Select an entity',
            ])
            ->add('networkAdmin', Select2EntityType::class, array(
                'remote_route' => 'cert_unlp_ngen_network_admin_search_autocomplete',
                'class' => NetworkAdmin::class,
                'minimum_input_length' => 3,
                'page_limit' => 10,
                'placeholder' => 'Select an admin',
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
            array('class' => 'save btn btn-primary btn-block', 'data-style' => 'slide-down'),
        ));

        $builder->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) {
            $network = $event->getData();
            $form = $event->getForm();
            if ($network) {
                $form->get('address')->setData($network->getAddressAndMask());
            }
        });
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Network::class,
            'csrf_protection' => false,
            'error_mapping' => [
                'domain' => 'address',
                'ip' => 'address',
            ],
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
