<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Users extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{

    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function getOrder()
    {
        return 1;
    }

    public function load(ObjectManager $manager)
    {

        $names = array('admin');
        $userManager = $this->container->get('fos_user.user_manager');

        foreach ($names as $name) {

            $user = $userManager->createUser();
            $user->setName($name);
            $user->setLastname($name);
            $user->setUsername($name);
            $user->setEmail($name . '@cert.com');
            $user->addRole('ROLE_API');
//            $passwordEnClaro = $name;
            $salt = md5(time());
//            $encoder = $this->container->get('security.encoder_factory')
//                    ->getEncoder($user);
//            $password = $encoder->encodePassword($passwordEnClaro, $salt);

            $user->setApiKey(sha1($name . time() . $salt));
            $user->setPlainPassword($name);
//            $user->setSalt($salt);
            $user->setEnabled(true);


            $manager->persist($user);

            $this->addReference('user-' . $name, $user);
        }

        $manager->flush();
    }

}
