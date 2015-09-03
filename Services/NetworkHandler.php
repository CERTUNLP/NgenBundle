<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Services;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\FormFactoryInterface;
use CertUnlp\NgenBundle\Exception\InvalidFormException;
use Symfony\Component\Security\Core\SecurityContext;

class NetworkHandler {

    private $om;
    private $entityClass;
    private $repository;
    private $formFactory;

    public function __construct(ObjectManager $om, $entityClass, FormFactoryInterface $formFactory, SecurityContext $context, $default_network) {
        $this->om = $om;
        $this->entityClass = $entityClass;
        $this->repository = $this->om->getRepository($this->entityClass);
        $this->formFactory = $formFactory;
        $this->context = $context;
        $this->default_network = $default_network;
    }

    public function getUser() {
        return $this->context->getToken() ? $this->context->getToken()->getUser() : 'anon.';
    }

    /**
     * Get a Network.
     *
     * @param mixed $parameters
     *
     * @return NetworkInterface
     */
    public function get($parameters) {
        return $this->repository->findOneBy($parameters);
    }

    /**
     * Get a Network.
     *
     * @param mixed $parameters
     *
     * @return NetworkInterface
     */
    public function getByHostAddress($address) {
        $network = $this->repository->findByHostAddress($address);
        if (!$network && $this->default_network) {

            $network = $this->repository->findOneByIp($this->default_network);
        }
        return $network;
    }

    /**
     * Get a list of Networks.
     *
     * @param int $limit  the limit of the result
     * @param int $offset starting from the offset
     *
     * @return array
     */
    public function all($params = array(), $limit = null, $offset = null) {
        return $this->repository->findBy($params, null, $limit, $offset);
    }

    /**
     * Create a new Network.
     *
     * @param array $parameters
     *
     * @return NetworkInterface
     */
    public function post($parameters, $csrf_protection = false) {
        $network = $this->createNetwork();

        return $this->processForm($network, $parameters, 'POST', $csrf_protection);
    }

    /**
     * Edit a Network.
     *
     * @param NetworkInterface $network
     * @param array         $parameters
     *
     * @return NetworkInterface
     */
    public function put($network, array $parameters) {
        return $this->processForm($network, $parameters, 'PUT');
    }

    /**
     * Partially update a Network.
     *
     * @param NetworkInterface $network
     * @param array         $parameters
     *
     * @return NetworkInterface
     */
    public function patch($network, array $parameters) {
        return $this->processForm($network, $parameters, 'PATCH', false);
    }

    /**
     * Delete a Network.
     *
     * @param NetworkInterface $network
     * @param array $parameters
     *
     * @return NetworkInterface
     */
    public function delete($network, array $parameters = null) {
        $network->setIsActive(FALSE);
        $this->om->flush($network);
        return $network;
    }

    /**
     * Delete a Network.
     *
     * @param NetworkInterface $network
     * @param array $parameters
     *
     * @return NetworkInterface
     */
    public function desactivate($network, array $parameters = null) {

        return $this->delete($network);
    }

    /**
     * Delete a Network.
     *
     * @param NetworkInterface $network
     * @param array $parameters
     *
     * @return NetworkInterface
     */
    public function activate($network, array $parameters = null) {
        $network->setIsActive(TRUE);
        $this->om->flush($network);
        return $network;
    }

    /**
     * Delete a Network.
     *
     * @param NetworkInterface $network
     * @param array $parameters
     *
     * @return NetworkInterface
     */
//    public function changeState($network, $state) {
//
//        $network->setState($state);
//        return $this->processForm($network, [], 'PATCH', false);
//    }

    /**
     * Processes the form.
     *
     * @param NetworkInterface $network
     * @param array         $parameters
     * @param String        $method
     *
     * @return NetworkInterface
     *
     * @throws \CertUnlp\NgenBundle\Exception\InvalidFormException
     */
    private function processForm($network, $parameters, $method = "PUT", $csrf_protection = true) {

        $form = $this->formFactory->create(new \CertUnlp\NgenBundle\Form\NetworkType(), $network, array('csrf_protection' => $csrf_protection, 'method' => $method));
        $form->submit($parameters, 'PATCH' !== $method);

        if ($form->isValid()) {
            $network = $form->getData();

            $network = $this->checkIfNetworkExists($network, $method);
            $this->om->persist($network);
            $this->om->flush($network);

            return $network;
        }
        throw new InvalidFormException('Invalid submitted data', $form);
    }

    private function checkIfNetworkExists($network, $method) {
        $networkDB = $this->repository->findOneBy(['ip' => $network->getIP(), 'ipMask' => $network->getIpMask()]);

        if ($networkDB && $method == 'POST') {
            if (!$networkDB->getIsActive()) {
                $networkDB->setIsActive(TRUE);
                $networkDB->setNetworkAdmin($network->getNetworkAdmin());
                $networkDB->setAcademicUnit($network->getAcademicUnit());
            }
            $network = $networkDB;
        }
        return $network;
    }

    private function createNetwork() {

        return new $this->entityClass();
    }

}
