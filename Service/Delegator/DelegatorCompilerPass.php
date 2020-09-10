<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Service\Delegator;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Description of DelegatorCompilerPass
 *
 * @author dam
 */
class DelegatorCompilerPass implements CompilerPassInterface
{

    public function process(ContainerBuilder $container)
    {

        if (!$container->has(DelegatorChain::class)) {
            return;
        }

        $delegator = $container->findDefinition(DelegatorChain::class);

        $tagged_services = $container->findTaggedServiceIds('cert_unlp.ngen.incident.delegate');

        foreach ($tagged_services as $id => $tags) {
            foreach ($tags as $attributes) {
                $delegator->addMethodCall(
                    'addDelegate', array(new Reference($id), $attributes["alias"] ?? null, $attributes["priority"] ?? null)
                );
            }
        }
    }

}
