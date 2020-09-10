<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle;

use CertUnlp\NgenBundle\DependencyInjection\CertUnlpNgenExtension;
use CertUnlp\NgenBundle\Service\Delegator\DelegatorCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class CertUnlpNgenBundle extends Bundle
{

    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new DelegatorCompilerPass());
    }

    public function getContainerExtension()
    {
        return new CertUnlpNgenExtension();
    }

}
