<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Controller\Frontend\User;

use FOS\UserBundle\Controller\ResettingController;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\FOSUserEvents;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserResettingFrontendController extends ResettingController
{
    public function __construct()
    {
    }

    /**
     * @Route("/request", name="fos_user_resetting_request", methods="GET")
     */
    public function requestAction()
    {
        return $this->render('CertUnlpNgenBundle:User:Frontend/Resetting/request.html.twig');
    }

    /**
     * @Route("/send-email", name="fos_user_resetting_send_email", methods="POST")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function sendEmailAction(Request $request)
    {
        return parent::sendEmailAction($request);
    }

    /**
     * @Route("/check-email", name="fos_user_resetting_check_email", methods="GET")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function checkEmailAction(Request $request)
    {
        $username = $request->query->get('username');

        if (empty($username)) {
            // the user does not come from the sendEmail action
            return new RedirectResponse($this->generateUrl('fos_user_resetting_request'));
        }

        return $this->render('CertUnlpNgenBundle:User:Frontend/Resetting/check_email.html.twig', array(
            'tokenLifetime' => ceil($this->container->getParameter('fos_user.resetting.retry_ttl') / 3600),
        ));
    }

    /**
     * @Route("/reset/{token}", name="fos_user_resetting_reset")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param $token
     * @return null|RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function resetAction(Request $request, $token)
    {
        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->get('fos_user.resetting.form.factory');
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        $dispatcher = $this->get('event_dispatcher');

        $user = $userManager->findUserByConfirmationToken($token);

        if (null === $user) {
            throw new NotFoundHttpException(sprintf('The user with "confirmation token" does not exist for value "%s"', $token));
        }

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::RESETTING_RESET_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form = $formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::RESETTING_RESET_SUCCESS, $event);

            $userManager->updateUser($user);

            if (null === $response = $event->getResponse()) {
                $url = $this->generateUrl('fos_user_profile_show');
                $response = new RedirectResponse($url);
            }

            $dispatcher->dispatch(
                FOSUserEvents::RESETTING_RESET_COMPLETED, new FilterUserResponseEvent($user, $request, $response)
            );

            return $response;
        }

        return $this->render('CertUnlpNgenBundle:User:Frontend/Resetting/reset.html.twig', array(
            'token' => $token,
            'form' => $form->createView(),
        ));
    }

}
