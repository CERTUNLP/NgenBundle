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
use CertUnlp\NgenBundle\Entity\Incident\IncidentTlp;
use CertUnlp\NgenBundle\Entity\Incident\IncidentUrgency;
use CertUnlp\NgenBundle\Entity\Incident\State\IncidentState;
use CertUnlp\NgenBundle\Entity\User;
use CertUnlp\NgenBundle\Service\Listener\Form\IncidentTypeListener;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Exception;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class IncidentType extends AbstractType
{
    /**
     * @var IncidentTypeListener
     */
    private $incident_type_listener;

    public function __construct(IncidentTypeListener $incident_type_listener)
    {
        $this->incident_type_listener = $incident_type_listener;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * @throws Exception
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', null, array(
                'placeholder' => 'Choose an incident type',
                'required' => true,
                'query_builder' => static function (EntityRepository $er) {
                    return $er->createQueryBuilder('it')
                        ->where('it.active = TRUE');
                },
                'attr' => array('class' => 'incidentFilter'),
            ))
            ->add('address', null, array(
                'required' => true,
                'attr' => array('class' => 'incidentFilter', 'help_text', 'placeholder' => 'IPV(4|6)/mask or domain'),
                'label' => 'Address',
            ))
            ->add('feed', EntityType::class, array(
                'class' => IncidentFeed::class,
                'required' => true,
                'query_builder' => static function (EntityRepository $er) {
                    return $er->createQueryBuilder('it')
                        ->where('it.active = TRUE');
                },
                'attr' => array('class' => 'ltdFilter'),
            ))
            ->add('notes', TextareaType::class, array(
                'required' => false,
                'label' => 'Notes',
                'attr' => array('class' => 'ltdFilter', 'data-theme' => 'simple', 'help_text' => 'Add some notes/evidence in text format, it will be attached to the mail report.'),
            ))
            ->add('evidence_file', FileType::class, array(
                'label' => 'Report attachment',
                'required' => false,
                'attr' => array('class' => 'ltdFilter'),
            ))
            ->add('date', DateTimeType::class, array(
                'required' => false,
                'html5' => true,
                'input' => 'datetime',
                'widget' => 'single_text',
                'data' => new DateTime(),
                'attr' => array('class' => 'incidentDataFilter', 'type' => 'datetime-local', 'help_text' => 'If no date is selected, the date will be today.'),
            ))
            ->add('tlp', EntityType::class, array(
                'class' => IncidentTlp::class,
                'placeholder' => 'Choose an incident TLP',
                'attr' => array('class' => 'ltdFilter', 'help_text' => 'If none is selected, it may be selected by incident decisions.'),
            ))
            ->add('reporter', EntityType::class, array(
                'class' => User::class,
                'placeholder' => 'Choose a reporter',
                'attr' => array('class' => 'incidentDataFilter', 'help_text' => 'If none is selected, the reporter will be the logged user.'),
                'query_builder' => static function (EntityRepository $er) {
                    return $er->createQueryBuilder('it')
                        ->where('it.enabled = TRUE');
                }))
            ->add('assigned', EntityType::class, array(
                'class' => User::class,
                'required' => false,
                'placeholder' => 'Choose a responsable',
                'attr' => array('class' => 'incidentDataFilter', 'help_text' => 'If none is selected, the assigned will be empty.'),
                'query_builder' => static function (EntityRepository $er) {
                    return $er->createQueryBuilder('it')
                        ->where('it.enabled = TRUE');
                }))
            ->add('state', EntityType::class, array(
                'class' => IncidentState::class,
                'placeholder' => 'Choose an incident state',
                'attr' => array('class' => 'incidentDataFilter', 'help_text' => 'If none is selected, it may be selected by incident decisions.'),
                'query_builder' => static function (EntityRepository $er) {
                    return $er->createQueryBuilder('it')
                        ->where('it.active = TRUE');
                }))
            ->add('impact', EntityType::class, array(
                'class' => IncidentImpact::class,
                'placeholder' => 'Choose an impact level',
                'attr' => array('class' => 'incidentDataFilter', 'help_text' => 'If none is selected, it may be selected by incident decisions.'),
                'choice_label' => 'name',
            ))
            ->add('urgency', EntityType::class, array(
                'class' => IncidentUrgency::class,
                'placeholder' => 'Choose an urgency level.',
                'attr' => array('class' => 'incidentDataFilter', 'help_text' => 'If none is selected, it may be selected by incident decisions.'),
                'choice_label' => 'name',
            ))
            ->add('notSendReport', CheckboxType::class, array(
                'data' => false,
                'mapped' => true,
                'attr' => array('class' => 'incidentDataFilter', 'align_with_widget' => true),
                'required' => false,
                'label' => 'Do not send report',
            ))
            ->add('unattendedState', EntityType::class, array(
                'class' => IncidentState::class,
                'placeholder' => 'Choose an incident state',
                'attr' => array('class' => 'incidentDataFilter', 'help_text' => 'If none is selected, it may be selected by incident decisions.'),
                'query_builder' => static function (EntityRepository $er) {
                    return $er->createQueryBuilder('it')
                        ->where('it.active = TRUE');
                }))
            ->add('responseDeadLine', DateTimeType::class, array(
                'required' => false,
                'html5' => true,
                'input' => 'datetime',
                'widget' => 'single_text',
                'data' => new DateTime(),
                'attr' => array('class' => 'incidentDataFilter', 'type' => 'datetime-local', 'help_text' => 'If no date is selected, the date will be today.'),
            ))
            ->add('unsolvedState', EntityType::class, array(
                'class' => IncidentState::class,
                'placeholder' => 'Choose an incident state',
                'attr' => array('class' => 'incidentDataFilter', 'help_text' => 'If none is selected, it may be selected by incident decisions.'),
                'query_builder' => static function (EntityRepository $er) {
                    return $er->createQueryBuilder('it')
                        ->where('it.active = TRUE');
                }))
            ->add('solveDeadLine', DateTimeType::class, array(
                'required' => false,
                'html5' => true,
                'input' => 'datetime',
                'widget' => 'single_text',
                'data' => new DateTime(),
                'attr' => array('class' => 'incidentDataFilter', 'type' => 'datetime-local', 'help_text' => 'If no date is selected, the date will be today.'),
            ))
            ->add('id', HiddenType::class, array(
                'required' => false,
            ))
            ->add('save', SubmitType::class, array(
                'attr' => array('class' => 'save btn btn-primary btn-block', 'data-style' => 'slide-down'),
            ))
            ->addEventSubscriber($this->getIncidentTypeListener());

    }

    /**
     * @return IncidentTypeListener
     */
    public function getIncidentTypeListener(): IncidentTypeListener
    {
        return $this->incident_type_listener;
    }

    /**
     * @return EntityManagerInterface
     */
    public function getEntityManager(): EntityManagerInterface
    {
        return $this->entity_manager;
    }

    /**
     * @return Security
     */
    public function getUserLogged(): Security
    {
        return $this->userLogged;
    }

    /**
     * @param OptionsResolver $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
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
