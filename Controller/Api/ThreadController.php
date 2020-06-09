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
use Symfony\Component\DependencyInjection\ContainerInterface;

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
}
