<?php
/**
 * This file is part of the Ngen - CSIRT Incident Report System.
 *   (c) CERT UNLP <support@cert.unlp.edu.ar>
 *  This source file is subject to the GPL v3.0 license that is bundled
 *  with this source code in the file LICENSE.
 */

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Form\Incident;

use CertUnlp\NgenBundle\Entity\Incident\Incident;
use CertUnlp\NgenBundle\Entity\Incident\IncidentFeed;
use CertUnlp\NgenBundle\Entity\Incident\IncidentImpact;
use CertUnlp\NgenBundle\Entity\Incident\IncidentTlp;
use CertUnlp\NgenBundle\Entity\Incident\IncidentType as IncidentTypeEntity;
use CertUnlp\NgenBundle\Entity\Incident\IncidentUrgency;
use CertUnlp\NgenBundle\Entity\Incident\State\IncidentState;
use CertUnlp\NgenBundle\Entity\User\User;
use CertUnlp\NgenBundle\Form\EntityType as EntityForm;
use CertUnlp\NgenBundle\Service\Listener\Form\EntityTypeListener;
use CertUnlp\NgenBundle\Service\Listener\Form\IncidentTypeListener;
use DateTime;
use Exception;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IncidentType extends EntityForm
{
    /**
     * @var IncidentTypeListener
     */
    private $incident_type_listener;

    public function __construct(EntityTypeListener $entity_type_listener, IncidentTypeListener $incident_type_listener)
    {
        $this->incident_type_listener = $incident_type_listener;
        parent::__construct($entity_type_listener);
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * @throws Exception
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $options['add_event_subscriber'] = false;
        $options['add_extra_fields'] = false;
        parent::buildForm($builder, $options);

        $builder
            ->add('type', EntityType::class, array(
                'class' => IncidentTypeEntity::class,
                'placeholder' => 'Choose an incident type',
                'required' => true,
                'attr' => array('class' => 'incidentFilter'),
            ))
            ->add('address', TextType::class, array(
                'required' => true,
                'attr' => array('class' => 'incidentFilter', 'help_text', 'placeholder' => 'IPV(4|6)/mask or domain'),
                'label' => 'Address',
            ))
            ->add('feed', EntityType::class, array(
                'class' => IncidentFeed::class,
                'required' => true,
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

            ))
            ->add('assigned', EntityType::class, array(
                'class' => User::class,
                'required' => false,
                'placeholder' => 'Choose a responsable',
                'attr' => array('class' => 'incidentDataFilter', 'help_text' => 'If none is selected, the assigned will be empty.'),
            ))
            ->add('state', EntityType::class, array(
                'class' => IncidentState::class,
                'placeholder' => 'Choose an incident state',
                'attr' => array('class' => 'incidentDataFilter', 'help_text' => 'If none is selected, it may be selected by incident decisions.'),
            ))
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
            ->add('unrespondedState', EntityType::class, array(
                'class' => IncidentState::class,
                'placeholder' => 'Choose an incident state',
                'attr' => array('class' => 'incidentDataFilter', 'help_text' => 'If none is selected, it may be selected by incident decisions.'),
            ))
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
            ))
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
            ));

        if (!$options['frontend']) {
            $builder->add('raw', TextareaType::class, array(
                'required' => false,
                'label' => 'Raw content',
                'attr' => array('class' => 'ltdFilter', 'data-theme' => 'simple', 'help_text' => 'Raw extra information decoded in base64'),
            ));
        }
        
        $builder->addEventSubscriber($this->getIncidentTypeListener());


    }

    /**
     * @return IncidentTypeListener
     */
    public function getIncidentTypeListener(): IncidentTypeListener
    {
        return $this->incident_type_listener;
    }

    /**
     * @param OptionsResolver $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);
        $resolver->setDefaults(array(
            'data_class' => Incident::class,
        ));
    }
}
