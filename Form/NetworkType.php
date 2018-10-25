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

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NetworkType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('ip', null, array(
                'attr' => array('placeholder' => 'e.g 192.168.1.1/16'),
                'label' => 'Ip/Mask',
                'description' => "The network ip and mask",
            ))
            ->add('networkAdmin', EntityType::class, array(
                'class' => 'CertUnlpNgenBundle:NetworkAdmin',
                'required' => true,
                'empty_value' => 'Choose an admin',
                'attr' => array('help_text' => 'This will be the network admin'),
                'description' => "The administrator responsible for the network",
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('na')
                        ->where('na.isActive = TRUE')
                        ->orderBy('na.name', 'ASC');
                }
            ))
            ->add('academicUnit', EntityType::class, array(
                'class' => 'CertUnlpNgenBundle:AcademicUnit',
                'required' => true,
                'empty_value' => 'Choose a unit',
                'attr' => array('help_text' => 'The unit to which the network belongs'),
                'description' => "The unit responsible, that owns the network",
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('au')
                        ->orderBy('au.name', 'ASC');
                }));

        if ($builder->getData()) {
            if (!$builder->getData()->getIsActive()) {
                $builder
                    ->add('reactivate', 'checkbox', array('data' => false, 'mapped' => false, 'label_attr' => array('class' => 'alert alert-warning'), 'attr' => array('align_with_widget' => true, 'help_text' => 'If it set to true the network will be reactivated.'), 'required' => false, 'label' => 'Reactivate?'));
            }
            $builder
                ->add('force_edit', 'checkbox', array('data' => false, 'mapped' => false, 'label_attr' => array('class' => 'alert alert-warning'), 'attr' => array('align_with_widget' => true, 'help_text' => 'If it set to true the network will be edited and not replaced.(this can harm the network history)'), 'required' => false, 'label' => 'Force edit'));
        }

        $builder->add('save', 'submit', array('attr' =>
            array('class' => 'save ladda-button btn-lg btn-block', 'data-style' => "slide-down"),
        ));

        $builder->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) {
            $network = $event->getData();
            $form = $event->getForm();
            // check if the Product object is "new"
            // If no data is passed to the form, the data is "null".
            // This should be considered a new "Product"
            if ($network) {
                $form->get('ip')->setData($network->getIpAndMask());
            }
        });
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CertUnlp\NgenBundle\Entity\Network',
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
