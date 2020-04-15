<?php

namespace CertUnlp\NgenBundle\Form\Listener;

use CertUnlp\NgenBundle\Entity\Incident\Incident;
use CertUnlp\NgenBundle\Entity\Incident\IncidentFeed;
use CertUnlp\NgenBundle\Entity\Incident\IncidentImpact;
use CertUnlp\NgenBundle\Entity\Incident\IncidentTlp;
use CertUnlp\NgenBundle\Entity\Incident\IncidentType;
use CertUnlp\NgenBundle\Entity\Incident\IncidentUrgency;
use CertUnlp\NgenBundle\Entity\Incident\State\IncidentState;
use CertUnlp\NgenBundle\Entity\User;
use CertUnlp\NgenBundle\Repository\IncidentStateRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class IncidentDefaultFieldsListener implements EventSubscriberInterface
{
    /**
     * @var EntityManager|null
     */
    private $doctrine;
    /**
     * @var int|null
     */
    private $userLogged;

    public function __construct(EntityManager $doctrine = null, int $userLogged = null)
    {
        $this->doctrine = $doctrine;
        $this->userLogged = $userLogged;
    }

    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::POST_SET_DATA => 'onPostSetData',
            FormEvents::PRE_SET_DATA => 'onPreSetData',
        );
    }

    public function onPostSetData(FormEvent $event)
    {
        /**
         * @var Incident $incident
         */
        $incident = $event->getData();

        $form = $event->getForm();
        // checks whether the user from the initial data has chosen to
        // display their email or not.
        if (!$form->getData()) {
            $form->get('type')->setData($this->getDoctrine() ? $this->getDoctrine()->getReference(IncidentType::class, 'undefined') : null);
            $form->get('feed')->setData($this->getDoctrine() ? $this->getDoctrine()->getReference(IncidentFeed::class, 'undefined') : null);
            $form->get('state')->setData($this->getDoctrine() ? $this->getDoctrine()->getReference(IncidentState::class, 'undefined') : null);
            $form->get('unattendedState')->setData($this->getDoctrine() ? $this->getDoctrine()->getReference(IncidentState::class, 'undefined') : null);
            $form->get('unsolvedState')->setData($this->getDoctrine() ? $this->getDoctrine()->getReference(IncidentState::class, 'undefined') : null);
            $form->get('tlp')->setData($this->getDoctrine() ? $this->getDoctrine()->getReference(IncidentTlp::class, 'green') : null);
            $form->get('impact')->setData($this->getDoctrine() ? $this->getDoctrine()->getReference(IncidentImpact::class, 'undefined') : null);
            $form->get('urgency')->setData($this->getDoctrine() ? $this->getDoctrine()->getReference(IncidentUrgency::class, 'undefined') : null);
            $form->get('assigned')->setData($this->getUserLogged() !== null && $this->getDoctrine() ? $this->getDoctrine()->getReference(User::class, $this->getUserLogged()) : 'null ');
            $form->get('reporter')->setData($this->getUserLogged() !== null && $this->getDoctrine() ? $this->getDoctrine()->getReference(User::class, $this->getUserLogged()) : 'null ');

        } else {
            if ($incident->getOrigin()) {
                $form->get('address')->setData($incident->getOrigin()->getAddress());
            }
            if ($incident->getPriority()) {
                $form->get('impact')->setData($this->getDoctrine()->getReference(IncidentImpact::class, $incident->getPriority()->getImpact()->getSlug()));
                $form->get('urgency')->setData($this->getDoctrine()->getReference(IncidentUrgency::class, $incident->getPriority()->getUrgency()->getSlug()));
            }
            if ($incident->getState() && !$incident->canEditFundamentals()) {
                $form->add('type', null, array(
                    'empty_value' => 'Choose an incident type',
                    'required' => true,
                    'disabled' => 'disabled',
                    'query_builder' => static function (EntityRepository $er) {
                        return $er->createQueryBuilder('it')
                            ->where('it.isActive = TRUE');
                    }))
                    ->add('address', null, array(
                        'required' => true,
                        'disabled' => 'disabled',
                        'attr' => array('help_text', 'placeholder' => 'IPV(4|6)/mask or domain'),
                        'label' => 'Address',
                        'description' => 'The network ip and mask',
                    ));

            }
        }
        $formOptions = array(
            'class' => IncidentState::class,
            'query_builder' => static function (IncidentStateRepository $repository) use ($incident) {
                // call a method on your repository that returns the query builder
                // return $userRepository->createFriendsQueryBuilder($user);
                return $repository->queryNewStates($incident ? $incident->getState()->getSlug() : 'initial');
            },
        );

        // create the field, this is similar the $builder->add()
        // field name, field type, field options
        $form->add('state', EntityType::class, $formOptions);
    }

    /**
     * @return EntityManager|null
     */
    public function getDoctrine(): ?EntityManager
    {
        return $this->doctrine;
    }

    /**
     * @return int|null
     */
    public function getUserLogged(): ?int
    {
        return $this->userLogged;
    }
}