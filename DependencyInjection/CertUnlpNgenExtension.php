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

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class CertUnlpNgenExtension extends Extension
{

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);


        $container->setParameter('cert_unlp.ngen.team', $config['team']);
        $container->setParameter('cert_unlp.ngen.team.mail', $config['team']['mail']);
        $container->setParameter('cert_unlp.ngen.team.name', $config['team']['name']);
        $container->setParameter('cert_unlp.ngen.resources.path', '%kernel.root_dir%/Resources/');
        $container->setParameter('cert_unlp.ngen.global.sign', $config['global']['sign']);

        $container->setParameter('cert_unlp.ngen.incident.evidence.path', $config['incidents']['evidence']['path']);
        $container->setParameter('cert_unlp.ngen.incident.evidence.prefix', $config['incidents']['evidence']['prefix']);

        $container->setParameter('cert_unlp.ngen.incident.mailer.host', $config['incidents']['mailer']['host']);
        $container->setParameter('cert_unlp.ngen.incident.mailer.transport', $config['incidents']['mailer']['transport']);
        $container->setParameter('cert_unlp.ngen.incident.mailer.encryption', $config['incidents']['mailer']['encryption']);
        $container->setParameter('cert_unlp.ngen.incident.mailer.port', $config['incidents']['mailer']['port']);
        $container->setParameter('cert_unlp.ngen.incident.mailer.username', $config['incidents']['mailer']['username']);
        $container->setParameter('cert_unlp.ngen.incident.mailer.password', $config['incidents']['mailer']['password']);

        $container->setParameter('cert_unlp.ngen.grafana.internal.url', $config['grafana']['internal']);
        $container->setParameter('cert_unlp.ngen.grafana.external.url', $config['grafana']['external']);

        if (isset($config['incidents']['mailer']['sender_address'])) {
            $container->setParameter('cert_unlp.ngen.incident.mailer.sender_address', $config['incidents']['mailer']['sender_address']);
        } else {
            $container->setParameter('cert_unlp.ngen.incident.mailer.sender_address', $config['team']['mail']);
        }

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');
    }

}
