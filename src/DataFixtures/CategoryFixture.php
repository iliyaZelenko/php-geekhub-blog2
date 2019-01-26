<?php
/**
 * Created by PhpStorm.
 * User: yamadote
 * Date: 1/17/19
 * Time: 9:40 PM.
 */

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixture extends Fixture
{
    public const CATEGORY_OTHER_REFERENCE = 'category-other';

    public function load(ObjectManager $manager): void
    {
        $items = [
            [
                'title' => 'Symfony',
                'reference' => null,
            ], [
                'title' => 'Laravel',
                'reference' => null,
            ], [
                'title' => 'Other',
                'reference' => self::CATEGORY_OTHER_REFERENCE
            ],
        ];

        $order = 100000;

        foreach ($items as $item) {
            $category = new Category();
            $manager->persist($category);
            $category->setTitle($item['title']);

            $category->setOrder($order);
            $order += 1000;

            if ($item['reference'] !== null) {
                $this->setReference($item['reference'], $category);
            }
        }

        $manager->flush();
    }
}
