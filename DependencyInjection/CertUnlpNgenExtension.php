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

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class CertUnlpNgenExtension extends Extension {

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container) {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('cert_unlp.ngen.team.mail', $config['team']['mail']);

        $container->setParameter('cert_unlp.ngen.incident.class', $config['incidents']['class']);
        $container->setParameter('cert_unlp.ngen.incident.evidence.path', $config['incidents']['evidence']['path']);
        $container->setParameter('cert_unlp.ngen.incident.evidence.prefix', $config['incidents']['evidence']['prefix']);
        $container->setParameter('cert_unlp.ngen.incident.handler.class', $config['incidents']['handler']['class']);
        $container->setParameter('cert_unlp.ngen.incident.reporter.class', $config['incidents']['reporter']['class']);
        $container->setParameter('cert_unlp.ngen.incident.report.markdown.path', $config['incidents']['reports']['markdown']['path']);
        $container->setParameter('cert_unlp.ngen.incident.report.twig.path', $config['incidents']['reports']['twig']['path']);

        $container->setParameter('cert_unlp.ngen.incident.mailer.class', $config['incidents']['mailer']['class']);
        $container->setParameter('cert_unlp.ngen.incident.mailer.host', $config['incidents']['mailer']['host']);
        $container->setParameter('cert_unlp.ngen.incident.mailer.transport', $config['incidents']['mailer']['transport']);
        $container->setParameter('cert_unlp.ngen.incident.mailer.username', $config['incidents']['mailer']['username']);
        $container->setParameter('cert_unlp.ngen.incident.mailer.password', $config['incidents']['mailer']['password']);

        if (isset($config['incidents']['mailer']['sender_address'])) {
            $container->setParameter('cert_unlp.ngen.incident.mailer.sender_address', $config['incidents']['mailer']['sender_address']);
        } else {
            $container->setParameter('cert_unlp.ngen.incident.mailer.sender_address', $config['team']['mail']);
        }

        $container->setParameter('cert_unlp.ngen.seed.redmine.class', $config['seeds']['redmine']['class']);
        $container->setParameter('cert_unlp.ngen.seed.redmine.url', $config['seeds']['redmine']['url']);
        $container->setParameter('cert_unlp.ngen.seed.redmine.key', $config['seeds']['redmine']['key']);

        $container->setParameter('cert_unlp.ngen.feed.path', $config['feeds']['path']);
        $container->setParameter('cert_unlp.ngen.feed.shadowserver.class', $config['feeds']['shadowserver']['class']);
        $container->setParameter('cert_unlp.ngen.feed.shadowserver.client.class', $config['feeds']['shadowserver']['client']['class']);
        $container->setParameter('cert_unlp.ngen.feed.shadowserver.client.url', $config['feeds']['shadowserver']['client']['url']);
        $container->setParameter('cert_unlp.ngen.feed.shadowserver.client.user', $config['feeds']['shadowserver']['client']['user']);
        $container->setParameter('cert_unlp.ngen.feed.shadowserver.client.password', $config['feeds']['shadowserver']['client']['password']);


        $container->setParameter('cert_unlp.ngen.network.class', $config['networks']['class']);
        $container->setParameter('cert_unlp.ngen.network.default_network', $config['networks']['default_network']);
        $container->setParameter('cert_unlp.ngen.network.handler.class', $config['networks']['handler']['class']);
        $container->setParameter('cert_unlp.ngen.network.validator.class', $config['networks']['validator']['class']);


        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');
    }

}
