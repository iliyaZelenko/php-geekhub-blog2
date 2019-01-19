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

class CategoryFixtures extends Fixture
{
    public const CATEGORY_REFERENCE = 'category';

    public function load(ObjectManager $manager): void
    {
        $items = [
            ['title' => 'Symfony'],
            ['title' => 'Laravel'],
        ];

        $i = 100000;

        foreach ($items as $item) {
            $category = new Category();
            $manager->persist($category);
            $category->setTitle($item['title']);
            $category->setOrder($i);
            $i += 1000;
        }

        $category = new Category();
        $manager->persist($category);
        $category->setTitle('Other');
        $category->setOrder($i);
        $this->setReference(self::CATEGORY_REFERENCE, $category);

        $manager->flush();
    }
}
