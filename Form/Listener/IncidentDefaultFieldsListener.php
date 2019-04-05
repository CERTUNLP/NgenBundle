<?php

namespace CertUnlp\NgenBundle\Form\Listener;

use CertUnlp\NgenBundle\Entity\Incident\IncidentFeed;
use CertUnlp\NgenBundle\Entity\Incident\IncidentImpact;
use CertUnlp\NgenBundle\Entity\Incident\IncidentState;
use CertUnlp\NgenBundle\Entity\Incident\IncidentTlp;
use CertUnlp\NgenBundle\Entity\Incident\IncidentType;
use CertUnlp\NgenBundle\Entity\Incident\IncidentUrgency;
use CertUnlp\NgenBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class IncidentDefaultFieldsListener implements EventSubscriberInterface
{
    public function __construct(EntityManager $doctrine = null, int $userLogged = null)
    {
        $this->doctrine = $doctrine;
        $this->userLogged = $userLogged;
    }

    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::POST_SET_DATA => 'onPostSetData'
        );
    }

    public function onPostSetData(FormEvent $event)
    {
        $incident = $event->getData();
        $form = $event->getForm();
//       echo($form->getData()->getState());
//        echo($incident->getState());
//       die();
        // checks whether the user from the initial data has chosen to
        // display their email or not.
        if (!$form->getData()) {
            $form->get('type')->setData($this->doctrine ? $this->doctrine->getReference(IncidentType::class, 'undefined') : null);
            $form->get('feed')->setData($this->doctrine ? $this->doctrine->getReference(IncidentFeed::class, 'undefined') : null);
            $form->get('state')->setData($this->doctrine ? $this->doctrine->getReference(IncidentState::class, 'undefined') : null);
            $form->get('tlp')->setData($this->doctrine ? $this->doctrine->getReference(IncidentTlp::class, 'green') : null);
            $form->get('impact')->setData($this->doctrine ? $this->doctrine->getReference(IncidentImpact::class, 'undefined') : null);
            $form->get('urgency')->setData($this->doctrine ? $this->doctrine->getReference(IncidentUrgency::class, 'undefined') : null);
            $form->get('assigned')->setData($this->userLogged !== null && $this->doctrine ? $this->doctrine->getReference(User::class, $this->userLogged) : 'null ');
            $form->get('reporter')->setData($this->userLogged !== null && $this->doctrine ? $this->doctrine->getReference(User::class, $this->userLogged) : 'null ');
        } else {
            if ($incident->getOrigin()) {
                $form->get('address')->setData($incident->getOrigin()->getAddress());
            }
            if ($incident->getPriority()) {
                $form->get('impact')->setData($this->doctrine->getReference(IncidentImpact::class, $incident->getPriority()->getImpact()->getSlug()));
                $form->get('urgency')->setData( $this->doctrine->getReference(IncidentUrgency::class, $incident->getPriority()->getUrgency()->getSlug()));
            }
        }
    }
}