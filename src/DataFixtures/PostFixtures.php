<?php

namespace App\DataFixtures;

use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class PostFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $title = 'Title for test';
        $content = 'Content for test';

        $post = new Post();
        $post->setTitle($title);
        $post->setContent($content);

        $manager->persist($post);
        $manager->flush();
    }
}
