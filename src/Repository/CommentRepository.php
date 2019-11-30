<?php

namespace JK\CmsBundle\Repository;

use DateTime;
use JK\CmsBundle\Entity\Comment;
use JK\Repository\AbstractRepository;

class CommentRepository extends AbstractRepository
{
    /**
     * Return all comments created after $date.
     *
     * @return array
     */
    public function findByDate(DateTime $date, int $limit = 5)
    {
        return $this
            ->createQueryBuilder('comment')
            ->where('comment.createdAt > :date')
            ->setParameter('date', $date)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * Find all Comments from an Article that should be notified in case of new Comment.
     *
     * @return Comment[]
     */
    public function findShouldBeNotified(Comment $comment)
    {
        return $this
            ->createQueryBuilder('comment')
            ->where('comment.article = :article')
            ->andWhere('comment.notifyNewComments = :notify')
            ->andWhere('comment.id != :id')
            ->setParameter('article', $comment->getArticle()->getId())
            ->setParameter('notify', true)
            ->setParameter('id', $comment->getId())
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * Unsubscribe an email from the notifications send on new Comment.
     *
     * @param string $articleSlug
     * @param string $email
     *
     * @return Comment[]
     */
    public function findByArticleSlugAndEmail($articleSlug, $email): array
    {
        return $this
            ->createQueryBuilder('comment')
            ->innerJoin('comment.article', 'article')
            ->where('article.slug = :slug')
            ->andWhere('comment.authorEmail = :email')
            ->setParameter('slug', $articleSlug)
            ->setParameter('email', $email)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * Return the number of new Comment after a given date. If no Date is provided, return the number of all Comments.
     *
     * @return int
     */
    public function findNewCommentCount(DateTime $dateTime = null)
    {
        $queryBuilder = $this
            ->createQueryBuilder('comment')
            ->select('count(comment.id)')
        ;

        if (null !== $dateTime) {
            $queryBuilder
                ->where('comment.createdAt >= :date')
                ->setParameter('date', $dateTime)
            ;
        }

        return $queryBuilder
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }

    public function getEntityClass(): string
    {
        return Comment::class;
    }
}
