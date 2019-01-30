<?php
/**
 * Created by PhpStorm.
 * User: yamadote
 * Date: 1/15/19
 * Time: 11:36 AM.
 */

namespace App\Repository;

use App\Entity\FilterPost;
use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function findAllQueryBuilder(): QueryBuilder
    {
        return $this
            ->createQueryBuilder('post')
            ->orderBy('post.createdAt', 'DESC')
            ->join('post.category', 'category')
        ;
    }

    public function filterQueryBuilder(FilterPost $filter, QueryBuilder $queryBuilder = null): QueryBuilder
    {
        if ($queryBuilder === null) {
            $queryBuilder = $this->createQueryBuilder('post');
        }

        // filter by category

        if ($filter->getCategory() !== null) {
            $queryBuilder
                ->andWhere('post.category = :category')
                ->setParameter('category', $filter->getCategory())
            ;
        }

        // filter by createdAt

        $queryBuilder
            ->andWhere('( post.createdAt BETWEEN :from AND :to )
                OR ( :from IS NULL AND :to IS NULL )
                OR ( :from IS NULL AND post.createdAt <= :to )
                OR ( :to   IS NULL AND post.createdAt >= :from )')
            ->setParameter('from', $filter->getFrom())
            ->setParameter('to', $filter->getTo())
        ;

        return $queryBuilder;
    }

    /**
     * @return Post|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findMostRecent(): ?Post
    {
        return $this
            ->findAllQueryBuilder()
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findByTitleQueryBuilder($title)
    {
        return $this
            ->findAllQueryBuilder()
            ->where('post.title LIKE :title')
            ->setParameter('title', '%'.$title.'%')
        ;
    }
}
