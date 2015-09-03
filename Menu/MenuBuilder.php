<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class MenuBuilder extends ContainerAware {

    public function mainMenu(FactoryInterface $factory, array $options) {
        $menu = $factory->createItem('root');

//        $menu->addChild('Hme', array('route' => 'cert_unlp_ngen_incident_frontend_home'));
        // access services from the container!
//        $em = $this->container->get('doctrine')->getManager();
        // findMostRecent and Blog are just imaginary examples
//        $blog = $em->getRepository('AppBundle:Blog')->findMostRecent();
//        $menu->addChild('Latest Blog Post', array(
//            'route' => '/',
//            'routeParameters' => array('id' => $blog->getId())
//        ));
        // you can also add sub level's to your menu's as follows
        $menu->addChild('Incidents');

        $menu['Incidents']->addChild('Add incident', array('route' => 'cert_unlp_ngen_incident_new_incident'));

        $menu->addChild('Account');
        $menu['Account']->addChild('Logout', array('route' => 'cert_unlp_ngen_user_logout'));
        $menu['Account']->addChild('Change password', array('route' => 'cert_unlp_ngen_user_password_change'));
        // ... add more children

        return $menu;
    }

    public function leftNavbarMenu(FactoryInterface $factory, array $options) {
        $menu = $factory->createItem('root');

//        $menu->addChild('Home', array('route' => 'cert_unlp_ngen_incident_frontend_home'));
        // access services from the container!
//        $em = $this->container->get('doctrine')->getManager();
        // findMostRecent and Blog are just imaginary examples
//        $blog = $em->getRepository('AppBundle:Blog')->findMostRecent();
//        $menu->addChild('Latest Blog Post', array(
//            'route' => '/',
//            'routeParameters' => array('id' => $blog->getId())
//        ));
        // you can also add sub level's to your menu's as follows
        $menu->addChild('Incidents');

        $menu['Incidents']->addChild('Add incident', array('route' => 'cert_unlp_ngen_incident_new_incident'));

        return $menu;
    }

    public function rightNavbarMenu(FactoryInterface $factory, array $options) {
        $menu = $factory->createItem('root');

        $menu->addChild('Account');
        $menu['Account']->addChild('Change password', array('route' => 'cert_unlp_ngen_user_password_change'));
        $menu['Account']->addChild('Logout', array('route' => 'cert_unlp_ngen_user_logout'));
        // ... add more children

        return $menu;
    }

}
