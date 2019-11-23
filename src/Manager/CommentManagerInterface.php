<?php

namespace JK\CmsBundle\Manager;

use JK\CmsBundle\Entity\Comment;
use JK\CmsBundle\Factory\CommentFactoryInterface;

interface CommentManagerInterface
{
    public function unsubscribe(string $slug, string $email): void;

    public function save(Comment $comment): void;

    public function getFactory(): CommentFactoryInterface;
}
