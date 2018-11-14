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
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class IncidentDecisionType extends AbstractType
{
    public function __construct($doctrine=null) {
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
                'empty_value' => 'Choose an incident type',
                'required' => true,
                'description' => "(blacklist|botnet|bruteforce|bruteforcing_ssh|copyright|deface|"
                    . "dns_zone_transfer|dos_chargen|dos_ntp|dos_snmp|heartbleed|malware|open_dns open_ipmi|"
                    . "open_memcached|open_mssql|open_netbios|open_ntp_monitor|open_ntp_version|open_snmp|"
                    . "open_ssdp|phishing|poodle|scan|shellshock|spam)",
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('it')
                        ->where('it.isActive = TRUE');
                }))
            ->add('feed', 'entity', array(
                'class' => 'CertUnlpNgenBundle:IncidentFeed',
                'required' => true,
                'description' => "(bro|external_report|netflow|shadowserver)",
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('it')
                        ->where('it.isActive = TRUE');
                }))
            ->add('state', null, array(
                'empty_value' => 'Choose an incident state',
                'attr' => array('help_text' => 'If none is selected, the state will be \'open\'.'),
                'description' => "(open|closed|closed_by_inactivity|removed|unresolved|stand_by). If none is selected, the state will be 'open'.",
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('it')
                        ->where('it.isActive = TRUE');
                }))
            ->add('tlpState', null, array(
                'empty_value' => 'Choose an incident tlp',
                'attr' => array('help_text' => 'If none is selected, the state will be \'green\'.'),
                'description' => "(red|amber|green|white). If none is selected, the state will be 'green'.",
                'data' =>  $this->doctrine->getReference("CertUnlpNgenBundle:IncidentTlp", "green")
                ))
            ->add('impact', null, array(
                'empty_value' => 'Choose a impact level',
                'attr' => array('help_text' => 'If none is selected, the assigned impact will be Low.'),
                'description' => "If none is selected, the assigned impact will be Low",
            ))
            ->add('urgency', null, array(
                'empty_value' => 'Choose a responsable',
                'attr' => array('help_text' => 'If none is selected, the assigned urgency will be Low'),
                'description' => 'If none is selected, the assigned urgency will be Low',
            ))
            ->add('save', 'submit', array(
                'attr' => array('class' => 'save ladda-button btn-lg btn-block', 'data-style' => "slide-down"),
//                    'description' => "Evidence file that will be attached to the report "
            ));

    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CertUnlp\NgenBundle\Entity\IncidentDecision',
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
