<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Services\Api\Handler;

use CertUnlp\NgenBundle\Entity\Contact\Contact;
use CertUnlp\NgenBundle\Entity\Contact\ContactPhone;
use CertUnlp\NgenBundle\Entity\Contact\ContactTelegram;
use CertUnlp\NgenBundle\Entity\Contact\ContactEmail;
use CertUnlp\NgenBundle\Entity\Contact\ContactThreema;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\FormFactoryInterface;

class ContactHandler extends Handler
{
    public function post(array $parameters, bool $csrf_protection = false, $entity_class_instance = null)
    {

        switch ($parameters['contact_type']) {
            case 'telegram':
                $entity_class_instance = new ContactTelegram();
                break;
            case 'email':
                $entity_class_instance = new ContactEmail();
                break;
            case 'phone':
                $entity_class_instance = new ContactPhone();
                break;
            case 'threema':
                $entity_class_instance = new ContactThreema();
                break;

        }
        unset($parameters['type']);
        return parent::post($parameters, $csrf_protection, $entity_class_instance); // TODO: Change the autogenerated stub
    }


}