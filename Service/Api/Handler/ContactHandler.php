<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Service\Api\Handler;

use CertUnlp\NgenBundle\Entity\Contact\Contact;
use CertUnlp\NgenBundle\Entity\Contact\ContactEmail;
use CertUnlp\NgenBundle\Entity\Contact\ContactPhone;
use CertUnlp\NgenBundle\Entity\Contact\ContactTelegram;
use CertUnlp\NgenBundle\Entity\Contact\ContactThreema;
use CertUnlp\NgenBundle\Entity\Entity;
use Symfony\Component\Debug\Exception\ClassNotFoundException;

class ContactHandler extends Handler
{

//    protected function checkIfExists($entity, $method)
//    {
//        return $entity;
//    }

    /**
     * @param array $parameters
     * @return Entity| Contact
     * @throws ClassNotFoundException
     */
    public function createEntityInstance(array $parameters = []): Entity
    {
        switch ($parameters['contact_type']) {
            case 'telegram':
                $entity = new ContactTelegram();
                break;
            case 'email':
                $entity = new ContactEmail();
                break;
            case 'phone':
                $entity = new ContactPhone();
                break;
            case 'threema':
                $entity = new ContactThreema();
                break;
            default:
                throw new ClassNotFoundException('Contact class: "' . $parameters['contact_type'] . '" does not exist.', null);
        }
        unset($parameters['type']);
        return $entity;
    }


    /**
     * @param Entity|Contact $entity
     * @return array
     */
    public function getEntityIdentificationArray(Entity $entity): array
    {
        return ['id' => $entity->getId()];
    }
}
