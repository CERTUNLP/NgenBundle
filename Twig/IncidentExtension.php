<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Twig;

use Twig_Extension;
use Twig_SimpleFunction;
use CertUnlp\NgenBundle\Entity\Incident\IncidentState;


use Symfony\Bridge\Doctrine\RegistryInterface;

class IncidentExtension extends Twig_Extension
{
    public function getFunctions()
    {
        // Register the function in twig :
        // In your template you can use it as : {{findPosibleStates('open')}}
        return array(
            new Twig_SimpleFunction('findPosibleStates', array($this, 'findPosibleStates')),
            new Twig_SimpleFunction('getIconForStateAction', array($this, 'getIconForStateAction')),

        );
    }

    protected $doctrine;
    // Retrieve doctrine from the constructor
    public function __construct(RegistryInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function findPosibleStates($slug_state){
        $em = $this->doctrine->getManager();
        $myRepo = $em->getRepository('CertUnlpNgenBundle:Incident\IncidentState');
        return $myRepo->getPosibleChanges($slug_state);
    }

    public function getIconForStateAction($state_action){
        $text = '<i class="fas fa-exclamation-circle"></i>';
        if ($state_action === 'open'){
          $text = '<i class="fas fa-lock-open"></i>';
        }
        elseif ($state_action === 'close'){
            $text = '<i class="fas fa-lock"></i>';
        }
        elseif ($state_action === 'discard'){
            $text = '<i class="fas fa-trash-alt"></i>';
        }
        elseif ($state_action === 'new') {
            $text = '<i class="fas fa-circle-notch"></i>';
        }
        elseif ($state_action === 'open and close') {
            $text = '<i class="fas fa-envelope"></i>';
        }
        elseif ($state_action === 'reopen') {
            $text = '<i class="fas fa-recycle"></i>';
        }
        return $text;

    }
            public function getName()
    {
        return 'Twig Incident Extensions';
    }
}
