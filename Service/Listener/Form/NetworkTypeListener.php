<?php
/**
 * This file is part of the Ngen - CSIRT Incident Report System.
 *   (c) CERT UNLP <support@cert.unlp.edu.ar>
 *  This source file is subject to the GPL v3.0 license that is bundled
 *  with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Service\Listener\Form;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class NetworkTypeListener extends EntityTypeListener
{
    public static function getSubscribedEvents(): array
    {
        return array(
            FormEvents::POST_SET_DATA => 'onPostSetData',
        );
    }

    /**
     * @param FormEvent $event
     */
    public function onPostSetData(FormEvent $event): void
    {
        $network = $event->getData();
        $form = $event->getForm();
        if ($network) {
            $form->get('address')->setData($network->getAddressAndMask());
        }

    }

}