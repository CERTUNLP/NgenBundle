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

use CertUnlp\NgenBundle\Entity\Incident\Incident;
use CertUnlp\NgenBundle\Entity\Incident\IncidentDecision;
use CertUnlp\NgenBundle\Entity\Incident\IncidentFeed;
use CertUnlp\NgenBundle\Entity\Incident\IncidentReport;
use CertUnlp\NgenBundle\Entity\Incident\IncidentState;
use CertUnlp\NgenBundle\Entity\Message;
use CertUnlp\NgenBundle\Entity\Network\Network;
use CertUnlp\NgenBundle\Entity\Network\NetworkAdmin;
use CertUnlp\NgenBundle\Entity\Network\NetworkEntity;
use CertUnlp\NgenBundle\Entity\User;
use CertUnlp\NgenBundle\Form\IncidentDecisionType;
use CertUnlp\NgenBundle\Form\IncidentFeedType;
use CertUnlp\NgenBundle\Form\IncidentReportType;
use CertUnlp\NgenBundle\Form\IncidentStateType;
use CertUnlp\NgenBundle\Form\IncidentType;
use CertUnlp\NgenBundle\Form\IncidentTypeType;
use CertUnlp\NgenBundle\Form\NetworkAdminType;
use CertUnlp\NgenBundle\Form\NetworkEntityType;
use CertUnlp\NgenBundle\Form\NetworkType;
use CertUnlp\NgenBundle\Form\UserType;
use CertUnlp\NgenBundle\Services\Api\Handler\IncidentDecisionHandler;
use CertUnlp\NgenBundle\Services\Api\Handler\IncidentFeedHandler;
use CertUnlp\NgenBundle\Services\Api\Handler\IncidentHandler;
use CertUnlp\NgenBundle\Services\Api\Handler\IncidentReportHandler;
use CertUnlp\NgenBundle\Services\Api\Handler\IncidentStateHandler;
use CertUnlp\NgenBundle\Services\Api\Handler\IncidentTypeHandler;
use CertUnlp\NgenBundle\Services\Api\Handler\NetworkAdminHandler;
use CertUnlp\NgenBundle\Services\Api\Handler\NetworkEntityHandler;
use CertUnlp\NgenBundle\Services\Api\Handler\NetworkHandler;
use CertUnlp\NgenBundle\Services\Api\Handler\UserHandler;
use CertUnlp\NgenBundle\Services\Communications\IncidentMailer;
use CertUnlp\NgenBundle\Services\Delegator\ExternalIncidentDelegatorChain;
use CertUnlp\NgenBundle\Services\Delegator\InternalIncidentDelegatorChain;
use CertUnlp\NgenBundle\Services\IncidentFactory;
use CertUnlp\NgenBundle\Services\IncidentRedmine;
use CertUnlp\NgenBundle\Validator\Constraints\ValidAddressValidator;
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
        $this->addIncidentSection($rootNode);
        $this->addMessagesSection($rootNode);
        $this->addUserSection($rootNode);
        $this->addNetworkSection($rootNode);
        $this->addSeedSection($rootNode);
        $this->addNetworkEntitySection($rootNode);
        $this->addIncidentDecisionSection($rootNode);
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
            ->end()
            ->end();
    }


    private function addIncidentSection(ArrayNodeDefinition $rootNode): void
    {
        $rootNode
            ->children()
            ->arrayNode('incidents')
            ->addDefaultsIfNotSet()
            ->children()
            ->arrayNode('internal')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('class')
            ->defaultValue(Incident::class)
            ->end()
            ->arrayNode('handler')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('class')
            ->defaultValue(IncidentHandler::class)
            ->end()
            ->end()
            ->end()
            ->arrayNode('delegator_chain')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('class')
            ->defaultValue(InternalIncidentDelegatorChain::class)
            ->end()
            ->end()
            ->end()
            ->arrayNode('form_type')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('class')
            ->defaultValue(IncidentType::class)
            ->end()
            ->end()
            ->end()
            ->arrayNode('reports')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('lang')
            ->defaultValue('en')
            ->end()
            ->arrayNode('markdown')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('path')
            ->defaultValue('%kernel.root_dir%/../src/CertUnlp/NgenBundle/Resources/views/InternalIncident/Report/Markdown')
            ->end()
            ->end()
            ->end()
            ->arrayNode('twig')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('path')
            ->defaultValue('%kernel.root_dir%/../src/CertUnlp/NgenBundle/Resources/views/InternalIncident/Report/Twig')
            ->end()
            ->end()
            ->end()
            ->end()
            ->end()
            ->arrayNode('mailer')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('class')
            ->defaultValue(IncidentMailer::class)
            ->end()
            ->scalarNode('sender_address')
            ->end()
            ->end()
            ->end()
            ->end()
            ->end()
            ->arrayNode('external')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('class')
            ->defaultValue('CertUnlp\NgenBundle\Entity\Incident\ExternalIncident')
            ->end()
            ->arrayNode('handler')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('class')
            ->defaultValue('CertUnlp\NgenBundle\Services\Api\Handler\ExternalIncidentHandler')
            ->end()
            ->end()
            ->end()
            ->arrayNode('delegator_chain')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('class')
            ->defaultValue(ExternalIncidentDelegatorChain::class)
            ->end()
            ->end()
            ->end()
            ->arrayNode('form_type')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('class')
            ->defaultValue('CertUnlp\NgenBundle\Form\ExternalIncidentType')
            ->end()
            ->end()
            ->end()
            ->arrayNode('reports')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('lang')
            ->defaultValue('en')
            ->end()
            ->arrayNode('markdown')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('path')
            ->defaultValue('%kernel.root_dir%/../src/CertUnlp/NgenBundle/Resources/views/ExternalIncident/Report/Markdown')
            ->end()
            ->end()
            ->end()
            ->arrayNode('twig')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('path')
            ->defaultValue('%kernel.root_dir%/../src/CertUnlp/NgenBundle/Resources/views/ExternalIncident/Report/Twig')
            ->end()
            ->end()
            ->end()
            ->end()
            ->end()
            ->arrayNode('mailer')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('class')
            ->defaultValue(IncidentMailer::class)
            ->end()
            ->scalarNode('sender_address')
            ->end()
            ->end()
            ->end()
            ->end()
            ->end()
            ->arrayNode('mailer')
            ->children()
            ->scalarNode('transport')
            ->defaultValue('smtp')
            ->end()
            ->scalarNode('host')
            ->end()
            ->scalarNode('port')
            ->end()
            ->scalarNode('encryption')
            ->defaultValue('null')
            ->end()
            ->scalarNode('username')
            ->defaultValue('')
            ->end()
            ->scalarNode('password')
            ->defaultValue('')
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
            ->arrayNode('factory')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('class')
            ->defaultValue(IncidentFactory::class)
            ->end()
            ->end()
            ->end()
            ->arrayNode('reporter')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('class')
            ->defaultValue(User::class)
            ->end()
            ->end()
            ->end()
            ->arrayNode('feeds')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('class')
            ->defaultValue(IncidentFeed::class)
            ->end()
//                                ->end()
//                                ->end()
            ->arrayNode('handler')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('class')
            ->defaultValue(IncidentFeedHandler::class)
            ->end()
            ->end()
            ->end()
            ->arrayNode('form_type')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('class')
            ->defaultValue(IncidentFeedType::class)
            ->end()
            ->end()
            ->end()
            ->end()
            ->end()
            ->arrayNode('states')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('class')
            ->defaultValue(IncidentState::class)
            ->end()
            ->arrayNode('handler')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('class')
            ->defaultValue(IncidentStateHandler::class)
            ->end()
            ->end()
            ->end()
            ->arrayNode('form_type')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('class')
            ->defaultValue(IncidentStateType::class)
            ->end()
            ->end()
            ->end()
            ->end()
            ->end()
            ->arrayNode('types')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('class')
            ->defaultValue(\CertUnlp\NgenBundle\Entity\Incident\IncidentType::class)
            ->end()
            ->arrayNode('handler')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('class')
            ->defaultValue(IncidentTypeHandler::class)
            ->end()
            ->end()
            ->end()
            ->arrayNode('form_type')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('class')
            ->defaultValue(IncidentTypeType::class)
            ->end()
            ->end()
            ->end()
            ->arrayNode('reports')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('class')
            ->defaultValue(IncidentReport::class)
            ->end()
            ->arrayNode('handler')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('class')
            ->defaultValue(IncidentReportHandler::class)
            ->end()
            ->end()
            ->end()
            ->arrayNode('form_type')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('class')
            ->defaultValue(IncidentReportType::class)
            ->end()
            ->end()
            ->end()
            ->end()
            ->end()
            ->end()
            ->end()
            ->end()
            ->end()
            ->end();
    }

    private function addMessagesSection(ArrayNodeDefinition $rootNode): void
    {
        $rootNode
            ->children()
            ->arrayNode('messages')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('class')
            ->defaultValue(Message::class)
            ->end()
            ->arrayNode('handler')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('class')
            ->defaultValue(MessageHandler::class)
            ->end()
            ->end()
            ->end()
            ->end()
            ->end()
            ->end();
    }

    private function addUserSection(ArrayNodeDefinition $rootNode): void
    {
        $rootNode
            ->children()
            ->arrayNode('users')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('class')
            ->defaultValue(User::class)
            ->end()
            ->arrayNode('handler')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('class')
            ->defaultValue(UserHandler::class)
            ->end()
            ->end()
            ->end()
            ->arrayNode('form_type')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('class')
            ->defaultValue(UserType::class)
            ->end()
            ->end()
            ->end()
            ->end()
            ->end()
            ->end();
    }

    private function addNetworkSection(ArrayNodeDefinition $rootNode): void
    {
        $rootNode
            ->children()
            ->arrayNode('networks')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('class')
            ->defaultValue(Network::class)
            ->end()
            ->scalarNode('default_network')
            ->defaultValue('')
            ->end()
            ->arrayNode('handler')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('class')
            ->defaultValue(NetworkHandler::class)
            ->end()
            ->end()
            ->end()
            ->arrayNode('validator')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('class')
            ->defaultValue(ValidAddressValidator::class)
            ->end()
            ->end()
            ->end()
            ->arrayNode('form_type')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('class')
            ->defaultValue(NetworkType::class)
            ->end()
            ->end()
            ->end()
            ->arrayNode('admin')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('class')
            ->defaultValue(NetworkAdmin::class)
            ->end()
            ->arrayNode('handler')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('class')
            ->defaultValue(NetworkAdminHandler::class)
            ->end()
            ->end()
            ->end()
            ->arrayNode('form_type')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('class')
            ->defaultValue(NetworkAdminType::class)
            ->end()
            ->end()
            ->end()
            ->end()
            ->end()
            ->end()
            ->end();
    }

    private function addSeedSection(ArrayNodeDefinition $rootNode): void
    {
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
            ->defaultValue(IncidentRedmine::class)
            ->end()
            ->scalarNode('key')
            ->defaultNull()
            ->end()
            ->end()
            ->end()
            ->end()
            ->end()
            ->end();
    }

    private function addNetworkEntitySection(ArrayNodeDefinition $rootNode): void
    {
        $rootNode
            ->children()
            ->arrayNode('network_entity')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('class')
            ->defaultValue(NetworkEntity::class)
            ->end()
            ->arrayNode('handler')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('class')
            ->defaultValue(NetworkEntityHandler::class)
            ->end()
            ->end()
            ->end()
            ->arrayNode('form_type')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('class')
            ->defaultValue(NetworkEntityType::class)
            ->end()
            ->end()
            ->end()
            ->end()
            ->end();
    }

    private function addIncidentDecisionSection(ArrayNodeDefinition $rootNode): void
    {
        $rootNode
            ->children()
            ->arrayNode('incident_decision')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('class')
            ->defaultValue(IncidentDecision::class)
            ->end()
            ->arrayNode('handler')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('class')
            ->defaultValue(IncidentDecisionHandler::class)
            ->end()
            ->end()
            ->end()
            ->arrayNode('form_type')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('class')
            ->defaultValue(IncidentDecisionType::class)
            ->end()
            ->end()
            ->end()
            ->end()
            ->end();
    }

}
