<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $users = [
            [
                'firstname' => 'Barack',
                'lastname' => 'Obama',
                'address' => 'White House',
            ],
            [
                'firstname' => 'Britney',
                'lastname' => 'Spears',
                'address' => 'America',
            ],
            [
                'firstname' => 'Leonardo',
                'lastname' => 'DiCaprio',
                'address' => 'Titanic',
            ],
        ];

        foreach ($users as $userData) {
            $user = new User();
            $user->setFirstname($userData['firstname']);
            $user->setLastname($userData['lastname']);
            $user->setAddress($userData['address']);
            $manager->persist($user);
        }
        $manager->flush();
    }
}
