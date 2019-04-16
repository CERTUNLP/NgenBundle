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

class IncidentType extends AbstractType
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
            ->add('address', null, array(
                'required' => true,
                'attr' => array('help_text', 'placeholder' => 'IPV(4|6)/mask or domain'),
                'label' => 'Address',
                'description' => 'The network ip and mask',
            ))
            ->add('feed', EntityType::class, array(
                'class' => IncidentFeed::class,
                'required' => true,
                'description' => '(bro|external_report|netflow|shadowserver)',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('it')
                        ->where('it.isActive = TRUE');
                }))
            ->add('notes', TextareaType::class, array(
                'required' => false,
                'label' => 'Notes',
                'attr' => array('data-theme' => 'simple', 'help_text' => 'Add some notes/evidence in text format, it will be attached to the mail report.'),
                'description' => 'Add some notes/evidence in text format, it will be attached to the mail report.'
            ))
            ->add('evidence_file', FileType::class, array(
                'label' => 'Report attachment',
                'required' => false,
                'description' => 'Evidence file that will be attached to the report '))
            ->add('date', DateTimeType::class, array(
                'required' => false,
                'html5' => true,
                'input' => 'datetime',
                'widget' => 'single_text',
                'data' => new DateTime(),
                'attr' => array('type' => 'datetime-local', 'help_text' => 'If no date is selected, the date will be today.'),
                'description' => 'If no date is selected, the date will be today.',
            ))
            ->add('state', EntityType::class, array(
                'class' => IncidentState::class,
                'empty_value' => 'Choose an incident state',
                'attr' => array('help_text' => 'If none is selected, the state will be \'open\'.'),
                'description' => "(open|closed|closed_by_inactivity|removed|unresolved|stand_by). If none is selected, the state will be 'open'.",
                'query_builder' => function (EntityRepository $er) {
                 return $er->createQueryBuilder('it')
                        ->where('it.isActive = TRUE');
                }))
            ->add('tlp', EntityType::class, array(
                'class' => IncidentTlp::class,
                'empty_value' => 'Choose an incident tlp',
                'attr' => array('help_text' => 'If none is selected, the state will be \'green\'.'),
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
                'empty_value' => 'Choose a impact level',
                'attr' => array('help_text' => 'If none is selected, the assigned impact will be Low.'),
                'description' => 'If none is selected, the assigned impact will be Low',
            ))
            ->add('urgency', EntityType::class, array(
                'class' => IncidentUrgency::class,
                'empty_value' => 'Choose an Urgency',
                'attr' => array('help_text' => 'If none is selected, the assigned urgency will be Low'),
                'description' => 'If none is selected, the assigned urgency will be Low',
            ))
            ->add('sendReport', CheckboxType::class, array(
                'data' => true,
                'mapped' => true,
                'attr' => array('align_with_widget' => true),
                'required' => false,
                'label' => 'Send mail report(if available)',
                'description' => 'Send a mail report to the host administrator.'))
            ->add('id', HiddenType::class, array(
                'required' => false,
            ))
            ->add('isNew', HiddenType::class, array(
                'required' => false,
            ))
            ->add('isClosed', HiddenType::class, array(
                'required' => false,
            ))
            ->add('save', SubmitType::class, array(
                'attr' => array('class' => 'save ladda-button btn-lg btn-block', 'data-style' => 'slide-down'),
//                    'description' => "Evidence file that will be attached to the report "
            ))
            ->addEventSubscriber(new IncidentDefaultFieldsListener($this->doctrine, $this->userLogged))
            ->addEventListener(
                FormEvents::PRE_SET_DATA,
                array($this, 'onPreSetData')
            );

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

    public function onPreSetData(FormEvent $event)
    {

        // get the form
        $form = $event->getForm();

        // get the data if 'reviewing' the information
        /**
         * @var Invoices
         */
        $data = $event->getData();


        // disable field if it has been populated with a client already
        if ( $data and ! $data->isNew() )
          $form->add('type', null, array(
        'empty_value' => 'Choose an incident type',
        'required' => true,
        'disabled'=>"disabled",
        'description' => '(blacklist|botnet|bruteforce|bruteforcing_ssh|copyright|deface|'
            . 'dns_zone_transfer|dos_chargen|dos_ntp|dos_snmp|heartbleed|malware|open_dns open_ipmi|'
            . 'open_memcached|open_mssql|open_netbios|open_ntp_monitor|open_ntp_version|open_snmp|'
            . 'open_ssdp|phishing|poodle|scan|shellshock|spam)',
        'query_builder' => function (EntityRepository $er) {
            return $er->createQueryBuilder('it')
                ->where('it.isActive = TRUE');
        }))
        ->add('address', null, array(
            'required' => true,
            'disabled'=>"disabled",
            'attr' => array('help_text', 'placeholder' => 'IPV(4|6)/mask or domain'),
            'label' => 'Address',
            'description' => 'The network ip and mask',
        ))
        ->add('feed', EntityType::class, array(
            'class' => IncidentFeed::class,
            'required' => true,
            'disabled'=>"disabled",
            'description' => '(bro|external_report|netflow|shadowserver)',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('it')
                    ->where('it.isActive = TRUE');
            }));

    }

}
