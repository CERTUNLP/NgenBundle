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
use CertUnlp\NgenBundle\Entity\Incident\IncidentImpact;
use CertUnlp\NgenBundle\Entity\Incident\IncidentState;
use CertUnlp\NgenBundle\Entity\Incident\IncidentTlp;
use CertUnlp\NgenBundle\Entity\Incident\IncidentUrgency;
use CertUnlp\NgenBundle\Entity\User;
use CertUnlp\NgenBundle\Form\Listener\IncidentDefaultFieldsListener;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvents;

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
                'empty_value' => 'Choose an incident type',
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
            ->add('state', EntityType::class, array(
                'class' => IncidentState::class,
                'empty_value' => 'Choose an incident state',
                'attr' => array('help_text' => 'If none is selected, it may be selected by incident decisions.'),
                'description' => "(open|closed|closed_by_inactivity|removed|unresolved|stand_by). If none is selected, the state will be 'open'.",
                'query_builder' => function (EntityRepository $er) {
                 return $er->createQueryBuilder('it')
                        ->where('it.isActive = TRUE');
                }))
            ->add('tlp', EntityType::class, array(
                'class' => IncidentTlp::class,
                'empty_value' => 'Choose an incident TLP',
                'attr' => array('help_text' => 'If none is selected, it may be selected by incident decisions.'),
                'description' => "(red|amber|green|white). If none is selected, the state will be 'green'.",
            ))
            ->add('reporter', EntityType::class, array(
                'class' => User::class,
                'empty_value' => 'Choose a reporter',
                'attr' => array('help_text' => 'If none is selected, the reporter will be the logged user.'),
                'description' => 'The reporter ID. If none was selected, the reporter will be the logged user or the apikey user.',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('it')
                        ->where('it.enabled = TRUE');
                }))
            ->add('assigned', EntityType::class, array(
                'class' => User::class,
                'empty_value' => 'Choose a responsable',
                'attr' => array('help_text' => 'If none is selected, the assigned will be empty.'),
                'description' => 'If none was selected, the incident will remain unassigned.',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('it')
                        ->where('it.enabled = TRUE');
                }))
            ->add('impact', EntityType::class, array(
                'class' => IncidentImpact::class,
                'empty_value' => 'Choose an impact level',
                'attr' => array('help_text' => 'If none is selected, it may be selected by incident decisions.'),
                'description' => 'If none is selected, the assigned impact will be Low',
            ))
            ->add('urgency', EntityType::class, array(
                'class' => IncidentUrgency::class,
                'empty_value' => 'Choose an urgency level.',
                'attr' => array('help_text' => 'If none is selected, it may be selected by incident decisions.'),
                'description' => 'If none is selected, the assigned urgency will be Low',
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
            'csrf_protection' => false,
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
