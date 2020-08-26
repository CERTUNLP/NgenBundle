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

use CertUnlp\NgenBundle\Entity\Constituency\NetworkElement\Network;
use CertUnlp\NgenBundle\Entity\Incident\IncidentDecision;
use CertUnlp\NgenBundle\Entity\Incident\IncidentFeed;
use CertUnlp\NgenBundle\Entity\Incident\IncidentImpact;
use CertUnlp\NgenBundle\Entity\Incident\IncidentTlp;
use CertUnlp\NgenBundle\Entity\Incident\IncidentType;
use CertUnlp\NgenBundle\Entity\Incident\IncidentUrgency;
use CertUnlp\NgenBundle\Entity\Incident\State\IncidentState;
use CertUnlp\NgenBundle\Form\EntityType as EntityForm;
use CertUnlp\NgenBundle\Service\Listener\Form\EntityTypeListener;
use CertUnlp\NgenBundle\Service\Listener\Form\IncidentDecisionTypeListener;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

class IncidentDecisionType extends EntityForm
{
    /**
     * @var IncidentDecisionTypeListener
     */
    private $decision_type_listener;

    public function __construct(EntityTypeListener $entity_type_listener, IncidentDecisionTypeListener $decision_type_listener)
    {
        $this->decision_type_listener = $decision_type_listener;
        parent::__construct($entity_type_listener);
    }

    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', EntityType::class, [
                'class' => IncidentType::class,
                'required' => true,
                'query_builder' => static function (EntityRepository $er) {
                    return $er->createQueryBuilder('it')
                        ->where('it.active = TRUE');
                }])
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
            ->add('state', EntityType::class, array(
                'class' => IncidentState::class,
                'placeholder' => 'Choose an incident state',
                'query_builder' => static function (EntityRepository $er) {
                    return $er->createQueryBuilder('it')
                        ->where('it.active = TRUE');
                }))
            ->add('tlp', EntityType::class, array(
                'class' => IncidentTlp::class,
                'placeholder' => 'Choose an incident TLP',
            ))
            ->add('impact', EntityType::class, array(
                'class' => IncidentImpact::class,
                'placeholder' => 'Choose an impact level',
            ))
            ->add('urgency', EntityType::class, array(
                'class' => IncidentUrgency::class,
                'placeholder' => 'Choose an urgency level.',
            ))
            ->add('unattendedState', EntityType::class, array(
                'class' => IncidentState::class,
                'placeholder' => 'Choose an incident state',
                'query_builder' => static function (EntityRepository $er) {
                    return $er->createQueryBuilder('it')
                        ->where('it.active = TRUE');
                }))
            ->add('unsolvedState', EntityType::class, array(
                'class' => IncidentState::class,
                'placeholder' => 'Choose an incident state',
                'query_builder' => static function (EntityRepository $er) {
                    return $er->createQueryBuilder('it')
                        ->where('it.active = TRUE');
                }))
            ->add('id', HiddenType::class)
            ->addEventSubscriber($this->getDecisionTypeListener());
        $options['add_event_subscriber'] = false;

        parent::buildForm($builder, $options);
    }

    /**
     * @return IncidentDecisionTypeListener
     */
    public function getDecisionTypeListener(): IncidentDecisionTypeListener
    {
        return $this->decision_type_listener;
    }

    /**
     * @param OptionsResolver $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);
        $resolver->setDefaults(array(
            'data_class' => IncidentDecision::class,
        ));
    }
}
