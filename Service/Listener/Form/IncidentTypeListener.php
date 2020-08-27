<?php
/**
 * This file is part of the Ngen - CSIRT Incident Report System.
 *   (c) CERT UNLP <support@cert.unlp.edu.ar>
 *  This source file is subject to the GPL v3.0 license that is bundled
 *  with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Service\Listener\Form;

use CertUnlp\NgenBundle\Entity\Incident\Incident;
use CertUnlp\NgenBundle\Entity\Incident\IncidentFeed;
use CertUnlp\NgenBundle\Entity\Incident\IncidentImpact;
use CertUnlp\NgenBundle\Entity\Incident\IncidentTlp;
use CertUnlp\NgenBundle\Entity\Incident\IncidentType;
use CertUnlp\NgenBundle\Entity\Incident\IncidentUrgency;
use CertUnlp\NgenBundle\Entity\Incident\State\IncidentState;
use CertUnlp\NgenBundle\Entity\User;
use CertUnlp\NgenBundle\Repository\Incident\State\IncidentStateRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use JMS\Serializer\SerializerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Security\Core\Security;

class  IncidentTypeListener extends EntityTypeListener
{
    /**
     * @var Security
     */
    private $userLogged;

    public function __construct(SerializerInterface $serializer, EntityManagerInterface $entity_manager, Security $userLogged)
    {
        parent::__construct($serializer, $entity_manager);
        $this->userLogged = $userLogged;
    }

    public static function getSubscribedEvents(): array
    {
        $events = parent::getSubscribedEvents();
        $events[FormEvents::POST_SET_DATA] = 'onPostSetData';
        return $events;
    }

    /**
     * @param FormEvent $event
     * @throws ORMException
     */
    public function onPostSetData(FormEvent $event): void
    {
        $incident = $this->getIncident($event);

        $form = $event->getForm();
        $initial_states = $this->getInitialStates($incident);

        $form->add('state', EntityType::class, $initial_states);

        if (!$incident) {
            $form->get('type')->setData($this->getEntitymanager()->getReference(IncidentType::class, 'undefined'));
            $form->get('feed')->setData($this->getEntitymanager()->getReference(IncidentFeed::class, 'undefined'));
            $form->get('state')->setData($this->getEntitymanager()->getReference(IncidentState::class, 'undefined'));
            $form->get('unattendedState')->setData($this->getEntitymanager()->getReference(IncidentState::class, 'undefined'));
            $form->get('unsolvedState')->setData($this->getEntitymanager()->getReference(IncidentState::class, 'undefined'));
            $form->get('tlp')->setData($this->getEntitymanager()->getReference(IncidentTlp::class, 'green'));
            $form->get('impact')->setData($this->getEntitymanager()->getReference(IncidentImpact::class, 'undefined'));
            $form->get('urgency')->setData($this->getEntitymanager()->getReference(IncidentUrgency::class, 'undefined'));
            $form->get('reporter')->setData($this->getEntitymanager()->getReference(User::class, $this->getUserId()));
            $form->get('assigned')->setData($this->getEntitymanager()->getReference(User::class, $this->getUserId()));
        } else {
            if ($incident->getOrigin()) {
                $form->get('address')->setData($incident->getOrigin()->getAddress());
            }
            if ($incident->getPriority()) {
                $form->get('impact')->setData($this->getEntitymanager()->getReference(IncidentImpact::class, $incident->getPriority()->getImpact()->getSlug()));
                $form->get('urgency')->setData($this->getEntitymanager()->getReference(IncidentUrgency::class, $incident->getPriority()->getUrgency()->getSlug()));
            }
        }


    }

    /**
     * @param FormEvent $event
     * @return Incident
     */
    public function getIncident(FormEvent $event): ?Incident
    {
        return $event->getData();
    }

    /**
     * @param Incident|null $incident
     * @return array
     */
    public function getInitialStates(Incident $incident = null): array
    {
        return array(
            'class' => IncidentState::class,
            'query_builder' => static function (IncidentStateRepository $repository) use ($incident) {
                return $repository->queryNewStates($incident ? $incident->getState()->getSlug() : 'initial');
            },
        );
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return (int)$this->getEntitymanager()->getRepository(User::class)->findOneBy(['username' => $this->getUserLogged()->getUser()->getUsername()])->getId();
    }

    /**
     * @return Security
     */
    public function getUserLogged(): Security
    {
        return $this->userLogged;
    }

}