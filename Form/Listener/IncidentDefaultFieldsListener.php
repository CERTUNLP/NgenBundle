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
    public function __construct(EntityManager $doctrine, int $userLogged = null)
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

        // checks whether the user from the initial data has chosen to
        // display their email or not.
        if (!$form->getData()) {
            $form->get('type')->setData($this->doctrine->getReference(IncidentType::class, 'undefined'));
            $form->get('feed')->setData($this->doctrine->getReference(IncidentFeed::class, 'undefined'));
            $form->get('state')->setData($this->doctrine->getReference(IncidentState::class, 'undefined'));
            $form->get('tlp')->setData($this->doctrine->getReference(IncidentTlp::class, 'green'));
            $form->get('impact')->setData($this->doctrine->getReference(IncidentImpact::class, 'undefined'));
            $form->get('urgency')->setData($this->doctrine->getReference(IncidentUrgency::class, 'undefined'));
            $form->get('assigned')->setData($this->userLogged !== null ? $this->doctrine->getReference(User::class, $this->userLogged) : 'null ');
            $form->get('reporter')->setData($this->userLogged !== null ? $this->doctrine->getReference(User::class, $this->userLogged) : 'null ');
        } else {
            if ($incident->getOrigin()) {
                $form->get('ip_v4')->setData($incident->getOrigin()->getIpV4());
            }

        }
    }
}