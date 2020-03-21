<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $users = [
            ['name' => 'DEV1', 'difficulty' => 1],
            ['name' => 'DEV2', 'difficulty' => 2],
            ['name' => 'DEV3', 'difficulty' => 3],
            ['name' => 'DEV4', 'difficulty' => 4],
            ['name' => 'DEV5', 'difficulty' => 5],
        ];

        foreach ($users as $user) {
            $userEntity = new User();
            $userEntity->setName($user['name']);
            $userEntity->setDifficulty($user['difficulty']);
            $manager->persist($userEntity);
        }

        $manager->flush();
    }
}
