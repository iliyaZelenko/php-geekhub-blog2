<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    public const ADMIN_REFERENCE = 'user-admin';

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        $data = [
            [
                'email' => 'first.user@email.com',
                'password' => 'password',
                'roles' => [],
                'reference' => null,
            ],
            [
                'email' => 'admin.user@email.com',
                'password' => 'password',
                'roles' => ['ROLE_ADMIN'],
                'reference' => self::ADMIN_REFERENCE,
            ],
        ];

        foreach ($data as $item) {
            $user = new User();
            $manager->persist($user);
            $user->setEmail($item['email']);
            $user->setRoles($item['roles']);
            $user->setPassword($this->encoder->encodePassword($user, $item['password']));

            if ($item['reference'] !== null) {
                $this->setReference($item['reference'], $user);
            }
        }

        $manager->flush();
    }
}
