<?php

namespace JK\CmsBundle\Factory;

use JK\CmsBundle\Entity\Comment;

class CommentFactory implements CommentFactoryInterface
{
    public function create(
        string $authorName,
        string $content,
        bool $notifyNewComments = false,
        string $authorUrl = null,
        string $authorEmail = null
    ): Comment {
        $comment = new Comment();
        $comment->setAuthorName($authorName);
        $comment->setContent($content);
        $comment->setNotifyNewComments($notifyNewComments);

        if ($authorUrl) {
            $comment->setAuthorUrl($authorUrl);
        }

        if ($authorEmail) {
            $comment->setAuthorEmail($authorEmail);
        }

        return $comment;
    }
}
