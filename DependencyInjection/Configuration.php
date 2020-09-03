<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{

    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('cert_unlp_ngen');

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
            ->arrayNode('team')
            ->children()
            ->scalarNode('mail')
            ->isRequired()
            ->cannotBeEmpty()
            ->end()
            ->scalarNode('abuse')
            ->isRequired()
            ->cannotBeEmpty()
            ->end()
            ->scalarNode('url')
            ->isRequired()
            ->cannotBeEmpty()
            ->end()
            ->scalarNode('name')
            ->isRequired()
            ->cannotBeEmpty()
            ->end()
            ->end()
            ->end()
            ->end();

        $this->addConfigGlobal($rootNode);
        $this->addConfigGrafana($rootNode);
        $this->addIncidentSection($rootNode);
        return $treeBuilder;
    }

    private function addConfigGlobal(ArrayNodeDefinition $rootNode): void
    {
        $rootNode
            ->children()
            ->arrayNode('global')
            ->addDefaultsIfNotSet()
            ->children()
            ->booleanNode('sign')
            ->defaultValue('true')
            ->end()
            ->end()
            ->end();
    }

    private function addConfigGrafana(ArrayNodeDefinition $rootNode): void
    {
        $rootNode
            ->children()
            ->arrayNode('grafana')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('external')
            ->defaultValue('http://localhost:8001')
            ->end()
            ->scalarNode('internal')
            ->defaultValue('http://localhost:3000')
            ->end()
            ->scalarNode('user')
            ->defaultValue('admin')
            ->end()
            ->scalarNode('password')
            ->defaultValue('admin')
            ->end()
            ->end()
            ->end()
            ->end();
    }

    private function addIncidentSection(ArrayNodeDefinition $rootNode): void
    {
        $rootNode
            ->children()
            ->arrayNode('incident')
            ->addDefaultsIfNotSet()
            ->children()
            ->booleanNode('evidence_path')
            ->defaultValue('%kernel.root_dir%/Resources/incident/evidence')
            ->end()
            ->end()
            ->end();
    }
}
