<?php

namespace JK\CmsBundle\Repository;

use JK\CmsBundle\Entity\Article;
use JK\CmsBundle\Repository\AbstractRepository;
use DateTime;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Internal\Hydration\IterableResult;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleRepository extends AbstractRepository
{
    public function findByFilters(array $filters): Pagerfanta
    {
        $filters = $this->resolveFilters($filters);

        $queryBuilder = $this
            ->createQueryBuilder('article')
            ->distinct()
            ->andWhere('article.publicationStatus = :publication_status')
            ->andWhere('article.publicationDate <= :now')
            ->addOrderBy('article.publicationDate', 'desc')
            ->setParameter('publication_status', Article::PUBLICATION_STATUS_PUBLISHED)
            ->setParameter('now', new DateTime())
        ;

        if (null !== $filters['categorySlug']) {
            $queryBuilder
                ->addSelect('category')
                ->innerJoin('article.category', 'category')
                ->andWhere('category.slug = :category')
                ->setParameter('category', $filters['categorySlug']);
        }
        if (null !== $filters['slug']) {
            $queryBuilder
                ->andWhere('article.slug = :slug')
                ->setParameter('slug', $filters['slug']);
        }
        if (null !== $filters['tagSlug']) {
            $queryBuilder
                ->innerJoin('article.tags', 'tag')
                ->andWhere('tag.slug = :tag_slug')
                ->setParameter('tag_slug', $filters['tagSlug']);
        }
        if (null !== $filters['tag']) {
            $queryBuilder
                ->join('article.tags', 'tag')
                ->where('tag.name = :tag')
                ->setParameter('tag', $filters['tag'])
            ;
        }
        $adapter = new DoctrineORMAdapter($queryBuilder);
        $pager = new Pagerfanta($adapter);
        $pager->setMaxPerPage(10);
        $pager->setCurrentPage($filters['page']);

        return $pager;
    }

    /**
     * Find the latest published articles.
     *
     * @param int $count
     *
     * @return Article[]
     */
    public function findLatest($count = 6)
    {
        return $this
            ->createQueryBuilder('article')
            ->orderBy('article.publicationDate', 'desc')
            ->where('article.publicationStatus = :published')
            ->andWhere('article.publicationDate <= :now')
            ->setParameter('published', Article::PUBLICATION_STATUS_PUBLISHED)
            ->setParameter('now', new DateTime())
            ->setMaxResults($count)
            ->getQuery()
            ->getResult();
    }

    /**
     * Find all articles in a given category.
     *
     * @param string $categorySlug
     * @param int    $count
     *
     * @return Article[]|IterableResult
     */
    public function findByCategory($categorySlug, $count = 6)
    {
        return $this
            ->createQueryBuilder('article')
            ->orderBy('article.publicationDate', 'desc')
            ->innerJoin('article.category', 'category')
            ->where('article.publicationStatus = :published')
            ->andWhere('article.publicationDate <= :now')
            ->andWhere('category.slug = :slug')
            ->setParameter('published', Article::PUBLICATION_STATUS_PUBLISHED)
            ->setParameter('slug', $categorySlug)
            ->setParameter('now', new DateTime())
            ->setMaxResults($count)
            ->getQuery()
            ->iterate()
        ;
    }

    /**
     * Find articles created after $date.
     *
     * @param DateTime $date
     *
     * @return array
     */
    public function findByDate(DateTime $date)
    {
        return $this
            ->createQueryBuilder('article')
            ->where('article.createdAt > :date')
            ->setParameter('date', $date)
            ->getQuery()
            ->getResult();
    }

    /**
     * Find not published articles.
     *
     * @return array
     */
    public function findNotPublished()
    {
        return $this
            ->createQueryBuilder('article')
            ->where('article.publicationStatus != :publication_status')
            ->setParameter('publication_status', Article::PUBLICATION_STATUS_PUBLISHED)
            ->getQuery()
            ->getResult();
    }

    /**
     * Find published articles.
     *
     * @return Article[]|Collection
     */
    public function findPublished()
    {
        return $this
            ->createQueryBuilder('article')
            ->where('article.publicationStatus = :publication_status')
            ->setParameter('publication_status', Article::PUBLICATION_STATUS_PUBLISHED)
            ->orderBy('article.publicationDate', 'desc')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param array $terms
     * @param bool  $usePagination
     * @param int   $page
     *
     * @return Pagerfanta|Article[]
     */
    public function findByTerms(array $terms, $usePagination = true, $page = 1)
    {
        $queryBuilder = $this
            ->createQueryBuilder('article')
            ->leftJoin('article.category', 'category')
            ->leftJoin('article.tags', 'tag')
            ->orderBy('article.publicationDate', 'desc')
            ->where('article.publicationStatus = :publication_status')
            ->setParameter('publication_status', Article::PUBLICATION_STATUS_PUBLISHED)
            ->distinct(true)
        ;
        $i = 0;

        foreach ($terms as $term) {
            $queryBuilder
                ->andWhere('article.title like :term'.$i.' or category.name like :term'.$i.' or article.content like :term'.$i.' or tag.name like :term'.$i.'')
                ->setParameter('term'.$i, '%'.$term.'%')
            ;
            ++$i;
        }

        if (false === $usePagination) {
            return $queryBuilder
                ->getQuery()
                ->getResult()
            ;
        }
        $adapter = new DoctrineORMAdapter($queryBuilder, false, false);
        $pager = new Pagerfanta($adapter);
        $pager
            ->setMaxPerPage(10)
            ->setCurrentPage($page)
        ;

        return $pager;
    }

    protected function resolveFilters(array $filters): array
    {
        $resolver = new OptionsResolver();
        $resolver
            ->setDefaults([
                'categorySlug' => null,
                'tagSlug' => null,
                'tag' => null,
                'slug' => null,
                'year' => null,
                'month' => null,
                'page' => 1,
            ])
            ->setAllowedTypes('categorySlug', [
                'string',
                'null',
            ])
            ->setAllowedTypes('tagSlug', [
                'string',
                'null',
            ])
            ->setAllowedTypes('tag', [
                'string',
                'null',
            ])
            ->setAllowedTypes('slug', [
                'string',
                'null',
            ])
            ->setAllowedTypes('year', [
                'string',
                'null',
            ])
            ->setAllowedTypes('month', [
                'string',
                'null',
            ])
            ->setAllowedTypes('page', [
                'integer',
                'string',
            ])
        ;

        return $resolver->resolve($filters);
    }

    public function getEntityClass(): string
    {
        return Article::class;
    }
}
