<?php

namespace JK\CmsBundle\Factory;

use JK\CmsBundle\Entity\Comment;

interface CommentFactoryInterface extends FactoryInterface
{
    public function create(
        string $authorName,
        string $content,
        bool $notifyNewComments,
        string $authorUrl,
        string $authorEmail
    ): Comment;
}
