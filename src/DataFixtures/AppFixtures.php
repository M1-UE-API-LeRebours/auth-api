<?php

namespace App\DataFixtures;

use App\Entity\Todo;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{


    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher
    )
    {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $this->loadUsers($manager);
        $this->loadTodos($manager, $faker);
    }

    private function loadUsers(ObjectManager $manager): void
    {
        $data = ["jp@mail.dev","bf@mail.dev"];

        foreach ($data as $email) {
            $user = new User();
            $user->setEmail($email)
                ->setPassword($this->passwordHasher->hashPassword(
                    $user,
                    'password'
                ));
            $manager->persist($user);
        }

        $manager->flush();

    }

    private function loadTodos(ObjectManager $manager, Generator $faker): void
    {
        $users = $manager->getRepository(User::class)->findAll();

        for ($i = 0; $i < 10; $i++) {
            $todo = new Todo();
            $todo->setLabel($faker->sentence)
                ->setDone($faker->boolean)
                ->setUser($faker->randomElement($users));
            $manager->persist($todo);
        }

        $manager->flush();
    }
}
