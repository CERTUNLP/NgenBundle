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

use CertUnlp\NgenBundle\Entity\Incident\Incident;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;


class IncidentExtension extends AbstractExtension
{
    protected $doctrine;

    public function __construct(RegistryInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    // Retrieve doctrine from the constructor

    public function getFunctions()
    {
        // Register the function in twig :
        // In your template you can use it as : {{findPosibleStates('open')}}
        return array(
            new TwigFunction('findPosibleStates', array($this, 'findPosibleStates')),
            new TwigFunction('getIconForStateAction', array($this, 'getIconForStateAction')),

        );
    }

    public function findPosibleStates(Incident $incident)
    {
        return $incident->getState()->getNewStates();
    }

    public function getIconForStateAction(string $state_action)
    {
        $text = '<i class="fas fa-exclamation-circle"></i>';
        if ($state_action === 'open') {
            $text = '<i class="fas fa-lock-open"></i>';
        } elseif ($state_action === 'close') {
            $text = '<i class="fas fa-lock"></i>';
        } elseif ($state_action === 'discard') {
            $text = '<i class="fas fa-trash-alt"></i>';
        } elseif ($state_action === 'new') {
            $text = '<i class="fas fa-circle-notch"></i>';
        } elseif ($state_action === 'open and close') {
            $text = '<i class="fas fa-envelope"></i>';
        } elseif ($state_action === 'reopen') {
            $text = '<i class="fas fa-recycle"></i>';
        }
        return $text;

    }

    public function getName()
    {
        return 'Twig Incident Extensions';
    }
}
