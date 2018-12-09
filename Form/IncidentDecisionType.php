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

use CertUnlp\NgenBundle\Entity\Incident\IncidentFeed;
use CertUnlp\NgenBundle\Entity\Incident\IncidentImpact;
use CertUnlp\NgenBundle\Entity\Incident\IncidentState;
use CertUnlp\NgenBundle\Entity\Incident\IncidentTlp;
use CertUnlp\NgenBundle\Entity\Incident\IncidentUrgency;
use CertUnlp\NgenBundle\Entity\Network\Network;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

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
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('it')
                        ->where('it.isActive = TRUE');
                }))
            ->add('feed', EntityType::class, array(
                'class' => IncidentFeed::class,
                'required' => true,
                'description' => '(bro|external_report|netflow|shadowserver)',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('it')
                        ->where('it.isActive = TRUE');
                }))
            ->add('network', EntityType::class, array(
                'empty_value' => 'Choose a network',
                'class' => Network::class,
                'required' => false,
                'description' => '(bro|external_report|netflow|shadowserver)',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('it')
                        ->where('it.isActive = TRUE');
                }))
            ->add('state', null, array(
                'class' => IncidentState::class,
                'empty_value' => 'Choose an incident state',
                'description' => "(open|closed|closed_by_inactivity|removed|unresolved|stand_by). If none is selected, the state will be 'open'.",
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('it')
                        ->where('it.isActive = TRUE');
                }))
            ->add('tlp', null, array(
                'class' => IncidentTlp::class,
                'empty_value' => 'Choose an incident tlp',
                'description' => "(red|amber|green|white). If none is selected, the state will be 'green'.",
            ))
            ->add('impact', null, array(
                'class' => IncidentImpact::class,
                'empty_value' => 'Choose a impact level',
                'description' => 'If none is selected, the assigned impact will be Low',
            ))
            ->add('urgency', null, array(
                'class' => IncidentUrgency::class,
                'empty_value' => 'Choose a urgency level',
                'description' => 'If none is selected, the assigned urgency will be Low',
            ))
            ->add('id', HiddenType::class)
            ->add('save', SubmitType::class, array(
                'attr' => array('class' => 'save ladda-button btn-lg btn-block', 'data-style' => 'slide-down'),
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
