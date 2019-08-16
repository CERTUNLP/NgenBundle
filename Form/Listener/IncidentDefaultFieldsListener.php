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
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
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
            FormEvents::POST_SET_DATA => 'onPostSetData',
            FormEvents::PRE_SET_DATA => 'onPreSetData',
        );
    }

    public function onPreSetData(FormEvent $event)
    {

        // get the form
        $form = $event->getForm();

        // get the data if 'reviewing' the information
        /**
         * @var Incident
         */
        $data = $event->getData();

        // disable field if it has been populated with a client already


    }

    public function onPostSetData(FormEvent $event)
    {
        /**
         * @var Incident
         */
        $incident = $event->getData();

        $form = $event->getForm();
        // checks whether the user from the initial data has chosen to
        // display their email or not.
        if (!$form->getData()) {
            $form->get('type')->setData($this->doctrine ? $this->doctrine->getReference(IncidentType::class, 'undefined') : null);
            $form->get('feed')->setData($this->doctrine ? $this->doctrine->getReference(IncidentFeed::class, 'undefined') : null);
            $form->get('state')->setData($this->doctrine ? $this->doctrine->getReference(IncidentState::class, 'undefined') : null);
            $form->get('unattendedState')->setData($this->doctrine ? $this->doctrine->getReference(IncidentState::class, 'undefined') : null);
            $form->get('unsolvedState')->setData($this->doctrine ? $this->doctrine->getReference(IncidentState::class, 'undefined') : null);
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
                $form->get('urgency')->setData($this->doctrine->getReference(IncidentUrgency::class, $incident->getPriority()->getUrgency()->getSlug()));
            }
            if ($incident->getState() && !$incident->canEditFundamentals()) {
                $form->add('type', null, array(
                    'empty_value' => 'Choose an incident type',
                    'required' => true,
                    'disabled' => 'disabled',
                    'description' => '(blacklist|botnet|bruteforce|bruteforcing_ssh|copyright|deface|'
                        . 'dns_zone_transfer|dos_chargen|dos_ntp|dos_snmp|heartbleed|malware|open_dns open_ipmi|'
                        . 'open_memcached|open_mssql|open_netbios|open_ntp_monitor|open_ntp_version|open_snmp|'
                        . 'open_ssdp|phishing|poodle|scan|shellshock|spam)',
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
    }
}