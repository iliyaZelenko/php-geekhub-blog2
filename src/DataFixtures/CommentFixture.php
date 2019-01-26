<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class CommentFixture extends Fixture implements DependentFixtureInterface
{
    public const COUNT = 4;

    public function load(ObjectManager $manager): void
    {
        $data = [
            'content' => 'Some comment - %u',
            'user' => $this->getReference(UserFixture::USER_USER_REFERENCE),
            'post' => $this->getReference(sprintf(PostFixture::POST_POST_REFERENCE, 0)),
        ];

        for ($i = 0; $i < self::COUNT; ++$i) {
            $comment = new Comment();
            $manager->persist($comment);
            $comment->setContent(sprintf($data['content'], $i));
            $comment->setUser($data['user']);
            $comment->setPost($data['post']);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            PostFixture::class,
            UserFixture::class,
        ];
    }
}
