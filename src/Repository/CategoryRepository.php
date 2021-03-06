<?php
/**
 * Created by PhpStorm.
 * User: yamadote
 * Date: 1/17/19
 * Time: 9:32 PM.
 */

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    public function findAll(): array
    {
        return $this->findBy([], ['order' => 'ASC']);
    }
}
