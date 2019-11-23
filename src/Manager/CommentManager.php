<?php

namespace JK\CmsBundle\Manager;

use JK\CmsBundle\Entity\Comment;
use JK\CmsBundle\Factory\CommentFactoryInterface;
use JK\CmsBundle\Repository\CommentRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CommentManager implements CommentManagerInterface
{
    /**
     * @var CommentRepository
     */
    private $repository;

    /**
     * @var CommentFactoryInterface
     */
    private $factory;

    public function __construct(CommentRepository $repository, CommentFactoryInterface $factory)
    {
        $this->repository = $repository;
        $this->factory = $factory;
    }

    public function unsubscribe(string $slug, string $email): void
    {
        $comments = $this->repository->findByArticleSlugAndEmail($slug, $email);

        if (0 === count($comments)) {
            throw new NotFoundHttpException('No comments found for the email "'.$email.'" and the slug "'.$slug.'"');
        }

        foreach ($comments as $comment) {
            $comment->setNotifyNewComments(false);
            $this->repository->save($comment);
        }
    }

    public function save(Comment $comment): void
    {
        $this->repository->save($comment);
    }

    public function getFactory(): CommentFactoryInterface
    {
        return $this->factory;
    }
}
