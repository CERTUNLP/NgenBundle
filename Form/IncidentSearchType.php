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

use CertUnlp\NgenBundle\Entity\Incident\Incident;
use CertUnlp\NgenBundle\Entity\Incident\IncidentFeed;
use CertUnlp\NgenBundle\Entity\Incident\IncidentPriority;
use CertUnlp\NgenBundle\Entity\Incident\IncidentState;
use CertUnlp\NgenBundle\Entity\Incident\IncidentTlp;
use CertUnlp\NgenBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

class IncidentSearchType extends AbstractType
{
    private $userLogged;
    private $doctrine;

    public function __construct(EntityManager $doctrine = null, int $userLogged = null)
    {
        $this->doctrine = $doctrine;
        $this->userLogged = $userLogged;
    }


    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * @throws \Exception
     */

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', null, array(
                'label' => false,
                'required'=>false,
                'empty_value' => 'All',
                'description' => '(blacklist|botnet|bruteforce|bruteforcing_ssh|copyright|deface|'
                    . 'dns_zone_transfer|dos_chargen|dos_ntp|dos_snmp|heartbleed|malware|open_dns open_ipmi|'
                    . 'open_memcached|open_mssql|open_netbios|open_ntp_monitor|open_ntp_version|open_snmp|'
                    . 'open_ssdp|phishing|poodle|scan|shellshock|spam)',
                'attr' => array('class' => 'select-filter','search'=>'slug')
            ))
            ->add('feed', EntityType::class, array(
                'class' => IncidentFeed::class,
                'empty_value' => 'All',
                'required'=>false,
                'label' => false,
                'description' => '(bro|external_report|netflow|shadowserver)',
                'attr' => array('class' => 'select-filter','search'=>'slug')
            ))
            ->add('address', null, array(
                'required' => false,
                'attr' => array('help_text', 'placeholder' => 'IPV(4|6)/mask or domain'),
                'label' => false,
                'mapped'=> false,
                'description' => 'The network ip and mask',
                'attr' => array('class' => 'multiple-select-filter','search'=>json_encode(['ip','domain']),'index'=>'origin')
            ))
            ->add('date', DateTimeType::class, array(
                'required' => false,
                'label' => false,
                'html5' => true,
                'input' => 'datetime',
                'widget' => 'single_text',
                'attr' => array('class' => 'select-filter','type' => 'datetime-local','search'=>'id'),
                'description' => 'If no date is selected, the date will be today.',
            ))
            ->add('state', EntityType::class, array(
                'label' => false,
                'required'=>false,
                'class' => IncidentState::class,
                'empty_value' => 'All',
                'description' => "(open|closed|closed_by_inactivity|removed|unresolved|stand_by). If none is selected, the state will be 'open'.",
                'attr' => array('class' => 'select-filter','search'=>'slug')
            ))
            ->add('tlp', EntityType::class, array(
                'label' => false,
                'required'=>false,
                'class' => IncidentTlp::class,
                'empty_value' => 'All',
                'description' => "(red|amber|green|white). If none is selected, the state will be 'green'.",
                'attr' => array('class' => 'select-filter','search'=>'slug')
            ))
            ->add('reporter', EntityType::class, array(
                'label' => false,
                'required'=>false,
                'class' => User::class,
                'empty_value' => 'All',
                'description' => 'The reporter ID. If none was selected, the reporter will be the logged user or the apikey user.',
                'attr' => array('class' => 'select-filter','search'=>'id')
                ))
            ->add('assigned', EntityType::class, array(
                'label' => false,
                'required'=>false,
                'class' => User::class,
                'empty_value' => 'All',
                'description' => 'If none was selected, the incident will remain unassigned.',
                'attr' => array('class' => 'select-filter','search'=>'id')
                ))
            ->add('priority', EntityType::class, array(
                'label' => false,
                'required'=>false,
                'class' => IncidentPriority::class,
                'empty_value' => 'All',
                'description' => 'If none is selected, the assigned impact will be Low',
                'attr' => array('class' => 'select-filter','search'=>'slug')
            ));

        }

    /**
     * @param OptionsResolverInterface $resolver
     * @return void
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Incident::class,
            'csrf_protection' => true,
        ));
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return '';
    }


}
