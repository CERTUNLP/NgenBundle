<?php
/**
 * Created by PhpStorm.
 * User: dam
 * Date: 12/12/18
 * Time: 16:49
 */

namespace CertUnlp\NgenBundle\Entity\Incident\Listener;

use CertUnlp\NgenBundle\Entity\Network\NetworkExternal;
use CertUnlp\NgenBundle\Entity\Network\NetworkInternal;
use CertUnlp\NgenBundle\Entity\Network\NetworkRdap;
use FOS\ElasticaBundle\Event\TransformEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CustomPropertyListener implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return array(
            TransformEvent::POST_TRANSFORM => 'addCustomProperty',
        );
    }

    public function addCustomProperty(TransformEvent $event)
    {
        $document = $event->getDocument();
        $custom = $event->getObject();
        if (get_class($custom) === NetworkInternal::class) {
            $document->set('discr', 'internal');
        }
        if (get_class($custom) === NetworkExternal::class) {
            $document->set('discr', 'external');
        }
        if (get_class($custom) === NetworkRdap::class) {
            $document->set('discr', 'rdap');
        }
    }
}