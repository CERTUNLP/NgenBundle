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

class ExternalIncidentType extends AbstractType
{

    /**
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
            ->add('hostAddress', null, array(
                'attr' => array('maxlength' => '300', 'help_text' => 'Add more than one address separating them with a comma.'),
                'description' => "The host IP. (Add more than one address separating them with a comma.)"))
            ->add('reporter', null, array(
                'empty_value' => 'Choose a reporter',
                'attr' => array('help_text' => 'If none is selected, the reporter will be the logged user.'),
                'description' => "The reporter ID. If none was selected, the reporter will be the logged user or the apikey user.",
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('it')
                        ->where('it.enabled = TRUE');
                }))
            ->add('state', null, array(
                'empty_value' => 'Choose an incident state',
                'attr' => array('help_text' => 'If none is selected, the state will be \'open\'.'),
                'description' => "(open|closed|closed_by_inactivity|removed|unresolved|stand_by). If none is selected, the state will be 'open'.",
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('it')
                        ->where('it.isActive = TRUE');
                }))
            ->add('feed', 'entity', array(
                'class' => 'CertUnlpNgenBundle:IncidentFeed',
                'required' => true,
                'description' => "(bro|external_report|netflow|shadowserver)", 'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('it')
                        ->where('it.isActive = TRUE');
                }))
            ->add('date', 'datetime', array(
                'required' => false,
                'input' => 'datetime',
                'attr' => array('help_text' => 'If no date is selected, the date will be today.'),
                'description' => "If no date is selected, the date will be today.",
                'placeholder' => array(
                    'year' => 'Year', 'month' => 'Month', 'day' => 'Day',
                    'hour' => 'Hour', 'minute' => 'Minute', 'second' => 'Second',
                )))
            ->add('sendReport', 'checkbox', array(
                'data' => true,
                'mapped' => true,
                'attr' => array('align_with_widget' => true),
                'required' => false,
                'label' => 'Send mail report(if available)',
                'description' => "Send a mail report to the host administrator."))
            ->add('editReport', 'button', array(
                'label' => 'Edit the report',
                'attr' => array('class' => 'save ladda-button btn btn-primary', 'data-style' => "slide-down"),
//                    'description' => "JS button. Only works in frontend."
            ))
            ->add('reportEdit', 'textarea', array(
                'required' => false,
                'label' => 'Edit the report',
                'label_attr' => array('class' => 'hidden'),
                'attr' => array('class' => 'hidden', 'data-theme' => 'simple'),
                'description' => "JS textarea. Only works in frontend."
            ))
            ->add('slug', 'hidden', array(
                'required' => false,
            ))
            ->add('evidence_file', 'file', array(
                'label' => 'Report attachment',
                'required' => false,
                'description' => "Evidence file that will be attached to the report "))
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
            'data_class' => 'CertUnlp\NgenBundle\Model\IncidentInterface',
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
