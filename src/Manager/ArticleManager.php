<?php

namespace JK\CmsBundle\Manager;

use JK\CmsBundle\Entity\Article;
use JK\CmsBundle\Repository\ArticleRepository;

class ArticleManager extends AbstractManager implements ArticleManagerInterface
{
    /**
     * @var ArticleRepository
     */
    private $repository;

    public function __construct(ArticleRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $id
     *
     * @return Article|mixed
     */
    public function get(int $id): Article
    {
        $article = $this->repository->find($id);
        $this->throwExceptionIfNull($article);

        return $article;
    }

    /**
     * @param array      $criteria
     * @param array|null $orderBy
     *
     * @return Article|mixed
     */
    public function getOneBy(array $criteria, array $orderBy = null): Article
    {
        $article = $this->repository->findOneBy($criteria, $orderBy);
        $this->throwExceptionIfNull($article);

        return $article;
    }
}
