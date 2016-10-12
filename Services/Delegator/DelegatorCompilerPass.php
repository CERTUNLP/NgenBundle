<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Services\Delegator;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Description of DelegatorCompilerPass
 *
 * @author dam
 */
class DelegatorCompilerPass implements CompilerPassInterface {

    public function process(ContainerBuilder $container) {
        if (!$container->hasDefinition('cert_unlp.ngen.incident.internal.delegator_chain')) {
            return;
        }

        if (!$container->hasDefinition('cert_unlp.ngen.incident.external.delegator_chain')) {
            return;
        }

        $definition_internal_delegator = $container->getDefinition('cert_unlp.ngen.incident.internal.delegator_chain');
        $definition_external_delegator = $container->getDefinition('cert_unlp.ngen.incident.external.delegator_chain');

        $internal_tagged_services = $container->findTaggedServiceIds('cert_unlp.ngen.incident.internal.delegate');
        $external_tagged_services = $container->findTaggedServiceIds('cert_unlp.ngen.incident.external.delegate');

        foreach ($internal_tagged_services as $id => $tags) {
            foreach ($tags as $attributes) {

                $definition_internal_delegator->addMethodCall(
                        'addDelegate', array(new Reference($id), isset($attributes["alias"]) ? $attributes["alias"] : null, isset($attributes["priority"]) ? $attributes["priority"] : null)
                );
            }
        }

        foreach ($external_tagged_services as $id => $tags) {
            foreach ($tags as $attributes) {

                $definition_external_delegator->addMethodCall(
                        'addDelegate', array(new Reference($id), isset($attributes["alias"]) ? $attributes["alias"] : null, isset($attributes["priority"]) ? $attributes["priority"] : null)
                );
            }
        }
    }

}
