<?php

/*
 * This file is part of the FOSCommentBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Controller\Api;

use FOS\CommentBundle\Controller\ThreadController as BaseThreadController;
use FOS\CommentBundle\Model\CommentInterface;
use FOS\RestBundle\View\View;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Restful controller for the Threads.
 *
 * @author Alexander <iam.asm89@gmail.com>
 */
class ThreadController extends BaseThreadController
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function setContainer(\Psr\Container\ContainerInterface $container)
    {
    }

    /**
     * Forwards the action to the comment view on a successful form submission.
     *
     * @param FormInterface $form Form with the error
     * @param string $id Id of the thread
     * @param CommentInterface $parent Optional comment parent
     *
     * @return View
     */
    protected function onCreateCommentSuccess(FormInterface $form, $id, CommentInterface $parent = null)
    {
        return View::createRouteRedirect('fos_comment_get_thread_comment', ['id' => $id, 'commentId' => $form->getData()->getId(), 'apikey' => $this->getUser()->getApikey()], Response::HTTP_CREATED);
    }
}
