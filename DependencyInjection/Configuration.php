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

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface {

    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder() {
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
                ->end()
                ->end()
                ->end()
        ;

        $this->addIncidentSection($rootNode);
        $this->addNetworkSection($rootNode);
        $this->addFeedSection($rootNode);
        $this->addSeedSection($rootNode);
        return $treeBuilder;
    }

    private function addIncidentSection(ArrayNodeDefinition $rootNode) {
        $rootNode
                ->children()
                ->arrayNode('incidents')
                ->addDefaultsIfNotSet()
                ->children()
                ->scalarNode('class')
                ->defaultValue('CertUnlp\NgenBundle\Entity\Incident')
                ->end()
                ->arrayNode('mailer')
                ->children()
                ->scalarNode('class')
                ->defaultValue('CertUnlp\NgenBundle\Services\IncidentMailer')
                ->end()
                ->scalarNode('transport')
                ->defaultValue('smtp')
                ->end()
                ->scalarNode('host')
                ->end()
                ->scalarNode('username')
                ->end()
                ->scalarNode('password')
                ->end()
                ->scalarNode('sender_address')
                ->end()
                ->end()
                ->end()
                ->arrayNode('evidence')
                ->addDefaultsIfNotSet()
                ->children()
                ->scalarNode('path')
                ->defaultValue('%kernel.root_dir%/Resources/incident/evidence')
                ->end()
                ->scalarNode('prefix')
                ->defaultValue('')
                ->end()
                ->end()
                ->end()
                ->arrayNode('handler')
                ->addDefaultsIfNotSet()
                ->children()
                ->scalarNode('class')
                ->defaultValue('CertUnlp\NgenBundle\Services\IncidentHandler')
                ->end()
                ->end()
                ->end()
                ->arrayNode('reporter')
                ->addDefaultsIfNotSet()
                ->children()
                ->scalarNode('class')
                ->defaultValue('CertUnlp\NgenBundle\Entity\User')
                ->end()
                ->end()
                ->end()
                ->arrayNode('reports')
                ->addDefaultsIfNotSet()
                ->children()
                ->arrayNode('markdown')
                ->addDefaultsIfNotSet()
                ->children()
                ->scalarNode('path')
                ->defaultValue('%kernel.root_dir%/../src/CertUnlp/NgenBundle/Resources/views/Incident/Report/Markdown')
                ->end()
                ->end()
                ->end()
                ->arrayNode('twig')
                ->addDefaultsIfNotSet()
                ->children()
                ->scalarNode('path')
                ->defaultValue('%kernel.root_dir%/../src/CertUnlp/NgenBundle/Resources/views/Incident/Report/Twig')
                ->end()
                ->end()
                ->end()
                ->end()
                ->end()
                ->end()
                ->end()
                ->end()
        ;
    }

    private function addNetworkSection(ArrayNodeDefinition $rootNode) {
        $rootNode
                ->children()
                ->arrayNode('networks')
                ->addDefaultsIfNotSet()
                ->children()
                ->scalarNode('class')
                ->defaultValue('CertUnlp\NgenBundle\Entity\Network')
                ->end()
                ->scalarNode('default_network')
                ->defaultValue('')
                ->end()
                ->arrayNode('handler')
                ->addDefaultsIfNotSet()
                ->children()
                ->scalarNode('class')
                ->defaultValue('CertUnlp\NgenBundle\Services\NetworkHandler')
                ->end()
                ->end()
                ->end()
                ->arrayNode('validator')
                ->addDefaultsIfNotSet()
                ->children()
                ->scalarNode('class')
                ->defaultValue('CertUnlp\NgenBundle\Validator\Constraints\ValidNetworkValidator')
                ->end()
                ->end()
                ->end()
                ->end()
                ->end()
                ->end()
        ;
    }

    private function addFeedSection(ArrayNodeDefinition $rootNode) {
        $rootNode
                ->children()
                ->arrayNode('feeds')
                ->addDefaultsIfNotSet()
                ->children()
                ->scalarNode('path')
                ->defaultValue('%kernel.root_dir%/Resources/feed')
                ->end()
                ->arrayNode('shadowserver')
                ->canBeEnabled()
                ->addDefaultsIfNotSet()
                ->children()
                ->scalarNode('class')
                ->defaultValue('CertUnlp\NgenBundle\Services\ShadowServer\ShadowServerAnalyzer')
                ->end()
                ->arrayNode('client')
                ->addDefaultsIfNotSet()
                ->children()
                ->scalarNode('class')
                ->defaultValue('CertUnlp\NgenBundle\Services\ShadowServer\ShadowServerClient')
                ->end()
                ->scalarNode('url')
                ->defaultValue('https://dl.shadowserver.org/reports/index.php')
                ->end()
                ->scalarNode('user')
                ->defaultNull()
                ->end()
                ->scalarNode('password')
                ->defaultNull()
//                ->isRequired()
//                ->cannotBeEmpty()
                ->end()
                ->end()
                ->end()
                ->end()
                ->end()
                ->end()
                ->end()
                ->end()
        ;
    }

    private function addSeedSection(ArrayNodeDefinition $rootNode) {
        $rootNode
                ->children()
                ->arrayNode('seeds')
                ->addDefaultsIfNotSet()
                ->children()
                ->arrayNode('redmine')
                ->addDefaultsIfNotSet()
                ->children()
                ->scalarNode('url')
                ->defaultNull()
                ->end()
                ->scalarNode('class')
                ->defaultValue('CertUnlp\NgenBundle\Services\IncidentRedmine')
                ->end()
                ->scalarNode('key')
                ->defaultNull()
                ->end()
                ->end()
                ->end()
                ->end()
                ->end()
                ->end()
        ;
    }

}
