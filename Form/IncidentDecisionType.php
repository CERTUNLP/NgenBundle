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

use CertUnlp\NgenBundle\Entity\Incident\IncidentDecision;
use CertUnlp\NgenBundle\Entity\Incident\IncidentFeed;
use CertUnlp\NgenBundle\Entity\Incident\IncidentImpact;
use CertUnlp\NgenBundle\Entity\Incident\IncidentTlp;
use CertUnlp\NgenBundle\Entity\Incident\IncidentUrgency;
use CertUnlp\NgenBundle\Entity\Incident\State\IncidentState;
use CertUnlp\NgenBundle\Entity\Network\Network;
use CertUnlp\NgenBundle\Service\Listener\Form\IncidentDecisionTypeListener;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

class IncidentDecisionType extends AbstractType
{
    /**
     * @var EntityManagerInterface
     */
    private $entity_manager;

    public function __construct(EntityManagerInterface $entity_manager)
    {
        $this->entity_manager = $entity_manager;
    }

    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', null, [
                'class' => \CertUnlp\NgenBundle\Entity\Incident\IncidentType::class,
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
            ->add('state', null, array(
                'class' => IncidentState::class,
                'placeholder' => 'Choose an incident state',
                'query_builder' => static function (EntityRepository $er) {
                    return $er->createQueryBuilder('it')
                        ->where('it.active = TRUE');
                }))
            ->add('tlp', null, array(
                'class' => IncidentTlp::class,
                'placeholder' => 'Choose an incident TLP',
            ))
            ->add('impact', null, array(
                'class' => IncidentImpact::class,
                'placeholder' => 'Choose an impact level',
            ))
            ->add('urgency', null, array(
                'class' => IncidentUrgency::class,
                'placeholder' => 'Choose an urgency level.',
            ))
            ->add('unattendedState', null, array(
                'class' => IncidentState::class,
                'placeholder' => 'Choose an incident state',
                'query_builder' => static function (EntityRepository $er) {
                    return $er->createQueryBuilder('it')
                        ->where('it.active = TRUE');
                }))
            ->add('unsolvedState', null, array(
                'class' => IncidentState::class,
                'placeholder' => 'Choose an incident state',
                'query_builder' => static function (EntityRepository $er) {
                    return $er->createQueryBuilder('it')
                        ->where('it.active = TRUE');
                }))
            ->add('id', HiddenType::class)
            ->add('save', SubmitType::class, array(
                'attr' => array('class' => 'save btn btn-primary btn-block', 'data-style' => 'slide-down'),
            ))
            ->addEventSubscriber(new IncidentDecisionTypeListener($this->getEntityManager()));
    }

    /**
     * @return EntityManagerInterface
     */
    public function getEntityManager(): EntityManagerInterface
    {
        return $this->entity_manager;
    }

    /**
     * @param OptionsResolver $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => IncidentDecision::class,
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
