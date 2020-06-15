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

use CertUnlp\NgenBundle\Entity\Incident\IncidentDecision;
use CertUnlp\NgenBundle\Entity\Incident\IncidentFeed;
use CertUnlp\NgenBundle\Entity\Incident\IncidentImpact;
use CertUnlp\NgenBundle\Entity\Incident\IncidentTlp;
use CertUnlp\NgenBundle\Entity\Incident\IncidentUrgency;
use CertUnlp\NgenBundle\Entity\Incident\State\IncidentState;
use CertUnlp\NgenBundle\Entity\Network\Network;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

class IncidentDecisionType extends AbstractType
{
    private $doctrine;

    public function __construct($doctrine = null)
    {
        $this->doctrine = $doctrine;
    }

    /*
    **
    * @param FormBuilderInterface $builder
    * @param array $options
    */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', null, array(
                'class' => \CertUnlp\NgenBundle\Entity\Incident\IncidentType::class,
                'required' => true,
                'query_builder' => static function (EntityRepository $er) {
                    return $er->createQueryBuilder('it')
                        ->where('it.active = TRUE');
                }))
            ->add('feed', EntityType::class, array(
                'class' => IncidentFeed::class,
                'required' => true,
                'query_builder' => static function (EntityRepository $er) {
                    return $er->createQueryBuilder('it')
                        ->where('it.active = TRUE');
                }))
            ->add('network', Select2EntityType::class, [
                'remote_route' => 'cert_unlp_ngen_network_search_autocomplete',
                'class' => Network::class,
                'minimum_input_length' => 3,
                'page_limit' => 10,
                'placeholder' => 'Select a network',
            ])
            ->add('state', null, array(
                'class' => IncidentState::class,
                'placeholder' => 'Choose an incident state',
                'query_builder' => static function (EntityRepository $er) {
                    return $er->createQueryBuilder('it')
                        ->where('it.active = TRUE');
                }))
            ->add('tlp', null, array(
                'class' => IncidentTlp::class,
                'placeholder' => 'Choose an incident TLP',
            ))
            ->add('impact', null, array(
                'class' => IncidentImpact::class,
                'placeholder' => 'Choose an impact level',
            ))
            ->add('urgency', null, array(
                'class' => IncidentUrgency::class,
                'placeholder' => 'Choose an urgency level.',
            ))
            ->add('unattendedState', null, array(
                'class' => IncidentState::class,
                'placeholder' => 'Choose an incident state',
                'query_builder' => static function (EntityRepository $er) {
                    return $er->createQueryBuilder('it')
                        ->where('it.active = TRUE');
                }))
            ->add('unsolvedState', null, array(
                'class' => IncidentState::class,
                'placeholder' => 'Choose an incident state',
                'query_builder' => static function (EntityRepository $er) {
                    return $er->createQueryBuilder('it')
                        ->where('it.active = TRUE');
                }))
            ->add('id', HiddenType::class)
            ->add('save', SubmitType::class, array(
                'attr' => array('class' => 'save btn btn-primary btn-block', 'data-style' => 'slide-down'),
            ));
        $doctrine = $this->doctrine;
        $builder->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) use ($doctrine) {
            $network = $event->getData();
            $form = $event->getForm();
            // check if the Product object is "new"
            // If no data is passed to the form, the data is "null".
            // This should be considered a new "Product"
            if (!$network) {
                $form->get('type')->setData($doctrine->getReference(\CertUnlp\NgenBundle\Entity\Incident\IncidentType::class, 'undefined'));
                $form->get('feed')->setData($doctrine->getReference(IncidentFeed::class, 'undefined'));
                $form->get('state')->setData($doctrine->getReference(IncidentState::class, 'undefined'));
                $form->get('unattendedState')->setData($doctrine->getReference(IncidentState::class, 'undefined'));
                $form->get('unsolvedState')->setData($doctrine->getReference(IncidentState::class, 'undefined'));
                $form->get('impact')->setData($doctrine->getReference(IncidentImpact::class, 'undefined'));
                $form->get('urgency')->setData($doctrine->getReference(IncidentUrgency::class, 'undefined'));
                $form->get('tlp')->setData($doctrine->getReference(IncidentTlp::class, 'green'));
            }
        });
    }

    /**
     * @param OptionsResolver $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => IncidentDecision::class,
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
