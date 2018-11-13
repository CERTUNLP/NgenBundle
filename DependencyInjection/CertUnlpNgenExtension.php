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
//        var_dump($config,$configs);die;

        $container->setParameter('cert_unlp.ngen.team.mail', $config['team']['mail']);
        $container->setParameter('cert_unlp.ngen.resources.path', '%kernel.root_dir%/Resources/');

        $container->setParameter('cert_unlp.ngen.incident.internal.class', $config['incidents']['internal']['class']);
        $container->setParameter('cert_unlp.ngen.incident.external.class', $config['incidents']['external']['class']);

        $container->setParameter('cert_unlp.ngen.incident.evidence.path', $config['incidents']['evidence']['path']);
        $container->setParameter('cert_unlp.ngen.incident.evidence.prefix', $config['incidents']['evidence']['prefix']);

        $container->setParameter('cert_unlp.ngen.incident.internal.handler.class', $config['incidents']['internal']['handler']['class']);
        $container->setParameter('cert_unlp.ngen.incident.external.handler.class', $config['incidents']['external']['handler']['class']);

        $container->setParameter('cert_unlp.ngen.incident.internal.delegator_chain.class', $config['incidents']['internal']['delegator_chain']['class']);
        $container->setParameter('cert_unlp.ngen.incident.external.delegator_chain.class', $config['incidents']['external']['delegator_chain']['class']);

        $container->setParameter('cert_unlp.ngen.incident.internal.form_type.class', $config['incidents']['internal']['form_type']['class']);
        $container->setParameter('cert_unlp.ngen.incident.external.form_type.class', $config['incidents']['external']['form_type']['class']);

        $container->setParameter('cert_unlp.ngen.incident.factory.class', $config['incidents']['factory']['class']);
        $container->setParameter('cert_unlp.ngen.incident.reporter.class', $config['incidents']['reporter']['class']);

        $container->setParameter('cert_unlp.ngen.incident.internal.report.lang', $config['incidents']['internal']['reports']['lang']);
        $container->setParameter('cert_unlp.ngen.incident.internal.report.markdown.path', $config['incidents']['internal']['reports']['markdown']['path']);
        $container->setParameter('cert_unlp.ngen.incident.internal.report.twig.path', $config['incidents']['internal']['reports']['twig']['path']);

        $container->setParameter('cert_unlp.ngen.incident.external.report.lang', $config['incidents']['external']['reports']['lang']);
        $container->setParameter('cert_unlp.ngen.incident.external.report.markdown.path', $config['incidents']['external']['reports']['markdown']['path']);
        $container->setParameter('cert_unlp.ngen.incident.external.report.twig.path', $config['incidents']['external']['reports']['twig']['path']);

        $container->setParameter('cert_unlp.ngen.incident.external.mailer.class', $config['incidents']['external']['mailer']['class']);
        $container->setParameter('cert_unlp.ngen.incident.internal.mailer.class', $config['incidents']['internal']['mailer']['class']);

        $container->setParameter('cert_unlp.ngen.incident.mailer.host', $config['incidents']['mailer']['host']);
        $container->setParameter('cert_unlp.ngen.incident.mailer.transport', $config['incidents']['mailer']['transport']);
        $container->setParameter('cert_unlp.ngen.incident.mailer.username', $config['incidents']['mailer']['username']);
        $container->setParameter('cert_unlp.ngen.incident.mailer.password', $config['incidents']['mailer']['password']);

        $container->setParameter('cert_unlp.ngen.incident.feed.class', $config['incidents']['feeds']['class']);
        $container->setParameter('cert_unlp.ngen.incident.feed.handler.class', $config['incidents']['feeds']['handler']['class']);
        $container->setParameter('cert_unlp.ngen.incident.feed.form_type.class', $config['incidents']['feeds']['form_type']['class']);

        $container->setParameter('cert_unlp.ngen.incident.state.class', $config['incidents']['states']['class']);
        $container->setParameter('cert_unlp.ngen.incident.state.handler.class', $config['incidents']['states']['handler']['class']);
        $container->setParameter('cert_unlp.ngen.incident.state.form_type.class', $config['incidents']['states']['form_type']['class']);

        $container->setParameter('cert_unlp.ngen.incident.type.class', $config['incidents']['types']['class']);
        $container->setParameter('cert_unlp.ngen.incident.type.handler.class', $config['incidents']['types']['handler']['class']);
        $container->setParameter('cert_unlp.ngen.incident.type.form_type.class', $config['incidents']['types']['form_type']['class']);

        $container->setParameter('cert_unlp.ngen.incident.type.report.class', $config['incidents']['types']['reports']['class']);
        $container->setParameter('cert_unlp.ngen.incident.type.report.handler.class', $config['incidents']['types']['reports']['handler']['class']);
        $container->setParameter('cert_unlp.ngen.incident.type.report.form_type.class', $config['incidents']['types']['reports']['form_type']['class']);

        $container->setParameter('cert_unlp.ngen.academic_unit.class', $config['academic_unit']['class']);
        $container->setParameter('cert_unlp.ngen.academic_unit.handler.class', $config['academic_unit']['handler']['class']);
        $container->setParameter('cert_unlp.ngen.academic_unit.form_type.class', $config['academic_unit']['form_type']['class']);

        $container->setParameter('cert_unlp.ngen.incident.decision.class', $config['incident_decision']['class']);
        $container->setParameter('cert_unlp.ngen.incident.decision.handler.class', $config['incident_decision']['handler']['class']);
        $container->setParameter('cert_unlp.ngen.incident.decision.form_type.class', $config['incident_decision']['form_type']['class']);

        if (isset($config['incidents']['mailer']['sender_address'])) {
            $container->setParameter('cert_unlp.ngen.incident.mailer.sender_address', $config['incidents']['mailer']['sender_address']);
        } else {
            $container->setParameter('cert_unlp.ngen.incident.mailer.sender_address', $config['team']['mail']);
        }

        if (isset($config['incidents']['internal']['mailer']['sender_address'])) {
            $container->setParameter('cert_unlp.ngen.incident.internal.mailer.sender_address', $config['incidents']['internal']['mailer']['sender_address']);
        } else {
            $container->setParameter('cert_unlp.ngen.incident.internal.mailer.sender_address', $container->getParameter('cert_unlp.ngen.incident.mailer.sender_address'));
        }

        if (isset($config['incidents']['external']['mailer']['sender_address'])) {
            $container->setParameter('cert_unlp.ngen.incident.external.mailer.sender_address', $config['incidents']['external']['mailer']['sender_address']);
        } else {
            $container->setParameter('cert_unlp.ngen.incident.external.mailer.sender_address', $container->getParameter('cert_unlp.ngen.incident.mailer.sender_address'));
        }

        $container->setParameter('cert_unlp.ngen.seed.redmine.class', $config['seeds']['redmine']['class']);
        $container->setParameter('cert_unlp.ngen.seed.redmine.url', $config['seeds']['redmine']['url']);
        $container->setParameter('cert_unlp.ngen.seed.redmine.key', $config['seeds']['redmine']['key']);

        $container->setParameter('cert_unlp.ngen.feed.path', $config['feeds']['path']);
        $container->setParameter('cert_unlp.ngen.feed.shadowserver.enabled', $config['feeds']['shadowserver']['enabled']);
        $container->setParameter('cert_unlp.ngen.feed.shadowserver.class', $config['feeds']['shadowserver']['class']);
        $container->setParameter('cert_unlp.ngen.feed.shadowserver.client.class', $config['feeds']['shadowserver']['client']['class']);
        $container->setParameter('cert_unlp.ngen.feed.shadowserver.client.url', $config['feeds']['shadowserver']['client']['url']);
        $container->setParameter('cert_unlp.ngen.feed.shadowserver.client.user', $config['feeds']['shadowserver']['client']['user']);
        $container->setParameter('cert_unlp.ngen.feed.shadowserver.client.password', $config['feeds']['shadowserver']['client']['password']);


        $container->setParameter('cert_unlp.ngen.network.class', $config['networks']['class']);
        $container->setParameter('cert_unlp.ngen.network.default_network', $config['networks']['default_network']);
        $container->setParameter('cert_unlp.ngen.network.handler.class', $config['networks']['handler']['class']);
        $container->setParameter('cert_unlp.ngen.network.validator.class', $config['networks']['validator']['class']);
        $container->setParameter('cert_unlp.ngen.network.form_type.class', $config['networks']['form_type']['class']);

        $container->setParameter('cert_unlp.ngen.network.admin.class', $config['networks']['admin']['class']);
        $container->setParameter('cert_unlp.ngen.network.admin.handler.class', $config['networks']['admin']['handler']['class']);
        $container->setParameter('cert_unlp.ngen.network.admin.form_type.class', $config['networks']['admin']['form_type']['class']);

        $container->setParameter('cert_unlp.ngen.user.class', $config['users']['class']);
        $container->setParameter('cert_unlp.ngen.user.handler.class', $config['users']['handler']['class']);
        $container->setParameter('cert_unlp.ngen.user.form_type.class', $config['users']['form_type']['class']);


        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');
    }

}
