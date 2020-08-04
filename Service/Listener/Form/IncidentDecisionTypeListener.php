<?php
/**
 * This file is part of the Ngen - CSIRT Incident Report System.
 *   (c) CERT UNLP <support@cert.unlp.edu.ar>
 *  This source file is subject to the GPL v3.0 license that is bundled
 *  with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Service\Listener\Form;

use CertUnlp\NgenBundle\Entity\Incident\IncidentFeed;
use CertUnlp\NgenBundle\Entity\Incident\IncidentImpact;
use CertUnlp\NgenBundle\Entity\Incident\IncidentTlp;
use CertUnlp\NgenBundle\Entity\Incident\IncidentType;
use CertUnlp\NgenBundle\Entity\Incident\IncidentUrgency;
use CertUnlp\NgenBundle\Entity\Incident\State\IncidentState;
use Doctrine\ORM\ORMException;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class IncidentDecisionTypeListener extends EntityTypeListener
{

    /**
     * {@inheritDoc}
     */
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
        $decision = $event->getData();
        $form = $event->getForm();
        if (!$decision) {
            $form->get('type')->setData($this->getEntitymanager()->getReference(IncidentType::class, 'undefined'));
            $form->get('feed')->setData($this->getEntitymanager()->getReference(IncidentFeed::class, 'undefined'));
            $form->get('state')->setData($this->getEntitymanager()->getReference(IncidentState::class, 'undefined'));
            $form->get('unattendedState')->setData($this->getEntitymanager()->getReference(IncidentState::class, 'undefined'));
            $form->get('unsolvedState')->setData($this->getEntitymanager()->getReference(IncidentState::class, 'undefined'));
            $form->get('impact')->setData($this->getEntitymanager()->getReference(IncidentImpact::class, 'undefined'));
            $form->get('urgency')->setData($this->getEntitymanager()->getReference(IncidentUrgency::class, 'undefined'));
            $form->get('tlp')->setData($this->getEntitymanager()->getReference(IncidentTlp::class, 'green'));
        }
    }

}