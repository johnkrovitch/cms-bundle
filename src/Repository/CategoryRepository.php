<?php

namespace JK\CmsBundle\Repository;

use JK\CmsBundle\Entity\Category;
use JK\CmsBundle\Repository\AbstractRepository;

/**
 * CategoryRepository.
 */
class CategoryRepository extends AbstractRepository
{
    /**
     * Return categories that should be display in homepage. They are indexed by slug.
     *
     * @return Category[]
     */
    public function findForHomepage()
    {
        return $this
            ->createQueryBuilder('category', 'category.slug')
            ->where('category.displayInHomepage = :display')
            ->setParameter('display', true)
            ->getQuery()
            ->getResult()
        ;
    }

    public function getEntityClass(): string
    {
        return Category::class;
    }
}
