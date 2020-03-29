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

use CertUnlp\NgenBundle\Entity\Communication\Behavior\CommunicationBehavior;
use CertUnlp\NgenBundle\Entity\Incident\IncidentFeed;
use CertUnlp\NgenBundle\Entity\Incident\IncidentImpact;
use CertUnlp\NgenBundle\Entity\Incident\IncidentTlp;
use CertUnlp\NgenBundle\Entity\Incident\IncidentUrgency;
use CertUnlp\NgenBundle\Entity\Incident\State\IncidentState;
use CertUnlp\NgenBundle\Entity\Network\Network;
use DateTime;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
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
                'description' => '(blacklist|botnet|bruteforce|bruteforcing_ssh|copyright|deface|'
                    . 'dns_zone_transfer|dos_chargen|dos_ntp|dos_snmp|heartbleed|malware|open_dns open_ipmi|'
                    . 'open_memcached|open_mssql|open_netbios|open_ntp_monitor|open_ntp_version|open_snmp|'
                    . 'open_ssdp|phishing|poodle|scan|shellshock|spam)',
                'query_builder' => static function (EntityRepository $er) {
                    return $er->createQueryBuilder('it')
                        ->where('it.isActive = TRUE');
                }))
            ->add('feed', EntityType::class, array(
                'class' => IncidentFeed::class,
                'required' => true,
                'description' => '(bro|external_report|netflow|shadowserver)',
                'query_builder' => static function (EntityRepository $er) {
                    return $er->createQueryBuilder('it')
                        ->where('it.isActive = TRUE');
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
                'empty_value' => 'Choose an incident state',
                'description' => "(open|closed|closed_by_inactivity|removed|unresolved|stand_by). If none is selected, the state will be 'open'.",
                'query_builder' => static function (EntityRepository $er) {
                    return $er->createQueryBuilder('it')
                        ->where('it.isActive = TRUE');
                }))
            ->add('tlp', null, array(
                'class' => IncidentTlp::class,
                'empty_value' => 'Choose an incident TLP',
                'description' => "(red|amber|green|white). If none is selected, the state will be 'green'.",
            ))
            ->add('impact', null, array(
                'class' => IncidentImpact::class,
                'empty_value' => 'Choose an impact level',
                'description' => 'If none is selected, the assigned impact will be Low',
            ))
            ->add('urgency', null, array(
                'class' => IncidentUrgency::class,
                'empty_value' => 'Choose an urgency level.',
                'description' => 'If none is selected, the assigned urgency will be Low',
            ))
            ->add('unattendedState', null, array(
                'class' => IncidentState::class,
                'empty_value' => 'Choose an incident state',
                'description' => "(open|closed|closed_by_inactivity|removed|unresolved|stand_by). If none is selected, the state will be 'open'.",
                'query_builder' => static function (EntityRepository $er) {
                    return $er->createQueryBuilder('it')
                        ->where('it.isActive = TRUE');
                }))
            ->add('unsolvedState', null, array(
                'class' => IncidentState::class,
                'empty_value' => 'Choose an incident state',
                'description' => "(open|closed|closed_by_inactivity|removed|unresolved|stand_by). If none is selected, the state will be 'open'.",
                'query_builder' => static function (EntityRepository $er) {
                    return $er->createQueryBuilder('it')
                        ->where('it.isActive = TRUE');
                }))
            ->add('communicationBehaviorNew', EntityType::class, array(
                'class' => CommunicationBehavior::class,
                'empty_value' => 'Choose an behavior',
                'description' => "(manual| Only text| Only files|All).",
                'query_builder' => static function (EntityRepository $er) {
                    return $er->createQueryBuilder('it')
                        ->where('it.isActive = TRUE');
                }
            ))
            ->add('communicationBehaviorOpen', EntityType::class, array(
                'class' => CommunicationBehavior::class,
                'empty_value' => 'Choose an behavior',
                'description' => "(manual| Only text| Only files|All).",
                'query_builder' => static function (EntityRepository $er) {
                    return $er->createQueryBuilder('it')
                        ->where('it.isActive = TRUE');
                }
            ))
            ->add('communicationBehaviorUpdate', EntityType::class, array(
                'class' => CommunicationBehavior::class,
                'empty_value' => 'Choose an behavior',
                'description' => "(manual| Only text| Only files|All).",
                'query_builder' => static function (EntityRepository $er) {
                    return $er->createQueryBuilder('it')
                        ->where('it.isActive = TRUE');
                }
            ))
            ->add('communicationBehaviorSummary', EntityType::class, array(
                'class' => CommunicationBehavior::class,
                'empty_value' => 'Choose an behavior',
                'description' => "(manual| Only text| Only files|All).",
                'query_builder' => static function (EntityRepository $er) {
                    return $er->createQueryBuilder('it')
                        ->where('it.isActive = TRUE');
                }
            ))
            ->add('communicationBehaviorClose', EntityType::class, array(
                'class' => CommunicationBehavior::class,
                'empty_value' => 'Choose an behavior',
                'description' => "(manual| Only text| Only files|All).",
                'query_builder' => static function (EntityRepository $er) {
                    return $er->createQueryBuilder('it')
                        ->where('it.isActive = TRUE');
                }
            ))
            ->add('whenToUpdate', DateTimeType::class, array(
                'required' => false,
                'html5' => true,
                'input' => 'datetime',
                'widget' => 'single_text',
                'data' => new DateTime(),
                'attr' => array('class' => 'incidentDataFilter', 'type' => 'datetime-local', 'help_text' => 'If no date is selected, the date will be today.'),
            ))
            ->add('whenToUpdate', ChoiceType::class, array(
                'choices' => array(
                    'Live' => 'live',
                    'Daily' => 'Daily',
                    'Weekly' => 'Weekly',

                ),
                'required' => true,
                'choices_as_values' => true
            ))
            ->add('id', HiddenType::class)
            ->add('save', SubmitType::class, array(
                'attr' => array('class' => 'save btn btn-primary btn-block', 'data-style' => 'slide-down'),
//                    'description' => "Evidence file that will be attached to the report "
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
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CertUnlp\NgenBundle\Entity\Incident\IncidentDecision',
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
