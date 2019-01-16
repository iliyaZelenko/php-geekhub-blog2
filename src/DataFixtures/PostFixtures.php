<?php

namespace App\DataFixtures;

use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class PostFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $title = 'Title for test - %u';
        $content = 'Content for test - %u';

        $count = 40;

        for ($i = 0; $i < $count; ++$i) {
            $post = new Post();
            $manager->persist($post);
            $post->setTitle(sprintf($title, $i));
            $post->setContent(sprintf($content, $i));
        }

        $manager->flush();
    }
}
