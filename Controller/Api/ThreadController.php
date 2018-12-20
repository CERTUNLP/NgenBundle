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

use FOS\CommentBundle\Model\CommentInterface;
use FOS\RestBundle\View\View;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Restful controller for the Threads.
 *
 * @author Alexander <iam.asm89@gmail.com>
 */
class ThreadController extends \FOS\CommentBundle\Controller\ThreadController
{

    /**
     * Forwards the action to the comment view on a successful form submission.
     *
     * @param FormInterface $form Form with the error
     * @param string $id Id of the thread
     *
     * @return View
     */
    protected function onEditCommentSuccess(FormInterface $form, $id)
    {
        return View::createRouteRedirect('fos_comment_get_thread_comment', array('id' => $id, 'commentId' => $form->getData()->getId()), Response::HTTP_CREATED);
    }

    /**
     * Forwards the action to the thread view on a successful form submission.
     *
     * @param FormInterface $form
     *
     * @return View
     */
    protected function onCreateThreadSuccess(FormInterface $form)
    {
        return View::createRouteRedirect('fos_comment_get_thread', array('id' => $form->getData()->getId()), Response::HTTP_CREATED);
    }

    /**
     * Forwards the action to the open thread edit view on a successful form submission.
     *
     * @param FormInterface $form
     *
     * @return View
     */
    protected function onOpenThreadSuccess(FormInterface $form)
    {
        return View::createRouteRedirect('fos_comment_edit_thread_commentable', array('id' => $form->getData()->getId(), 'value' => !$form->getData()->isCommentable()), Response::HTTP_CREATED);
    }

    /**
     * Forwards the action to the comment view on a successful form submission.
     *
     * @param FormInterface $form Comment delete form
     * @param int $id Thread id
     *
     * @return View
     */
    protected function onRemoveThreadCommentSuccess(FormInterface $form, $id)
    {
        return View::createRouteRedirect('fos_comment_get_thread_comment', array('id' => $id, 'commentId' => $form->getData()->getId()), Response::HTTP_CREATED);
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
        $apikey = $this->container->get('security.token_storage')->getToken()->getUser()->getApiKey();

        return View::createRouteRedirect('fos_comment_get_thread_comment', array('id' => $id, 'commentId' => $form->getData()->getId(), 'apikey' => $apikey), Response::HTTP_CREATED);
    }

    /**
     * Action executed when a vote was succesfully created.
     *
     * @param FormInterface $form Form with the error
     * @param string $id Id of the thread
     * @param mixed $commentId Id of the comment
     *
     * @return View
     *
     * @todo Think about what to show. For now the new score of the comment
     */
    protected function onCreateVoteSuccess(FormInterface $form, $id, $commentId)
    {
        return View::createRouteRedirect('fos_comment_get_thread_comment_votes', array('id' => $id, 'commentId' => $commentId), Response::HTTP_CREATED);
    }

}
