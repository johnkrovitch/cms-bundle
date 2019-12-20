<?php

namespace JK\CmsBundle\Manager;

use JK\CmsBundle\Entity\Article;

interface ArticleManagerInterface extends ManagerInterface
{
    public function get(int $id): Article;

    public function getOneBy(array $criteria, array $orderBy = null): Article;
}
