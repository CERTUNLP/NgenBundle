<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CertUnlp\NgenBundle\Services\Rdap;

//use CertUnlp\NgenBundle\Services\Rdap\Entity;
use stdClass;

/**
 * Description of Entity
 *
 * @author dam
 */
class DefaultEntity extends Entity
{

    private $email;

    /**
     * DefaultEntity constructor.
     * @param stdClass $entity_object
     * @param string $email
     */
    public function __construct(stdClass $entity_object = null, string $email)
    {
        $this->email = $email;
        parent::__construct(json_decode($this->getJson()));
    }

    private function getJson(): string
    {
        return '{
        "objectClassName":"entity",
        "handle":"Default Entity",
        "vcardArray":[
        "vcard",
        [
        [
        "version",
        {
        
        },
        "text",
                    "4.0"
                 ],
                 [
                     "fn",
                    {
        
                    },
                    "text",
                    "Default Entity"
                 ],
                 [
                     "email",
                    {
        
                    },
                    "text",
                    "' . $this->getEmail() . '"
                 ]
              ]
           ],
           "roles":[
            "abuse"
        ]
        }';
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return DefaultEntity
     */
    public function setEmail(string $email): DefaultEntity
    {
        $this->email = $email;
        return $this;
    }

    public function getLegajo()
    {
    }

    /**
     * @return array
     */
    public function getEmails(): array
    {
        return [$this->getEmail()];
    }

    /**
     * @param $name
     */
    public function __get($name)
    {
        // TODO: Implement __get() method.
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        // TODO: Implement __set() method.
    }

    /**
     * @param $name
     * @return bool
     */
    public function __isset($name)
    {
        return true;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return 'DefaultEntity';
    }
}
