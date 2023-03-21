<?php

namespace App\DataFixtures; 

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker;

class UserFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $passwordEncoder,

    ){}

    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin->setEmail('admin@gmail.com');
        $admin->setLastname('Admin');
        $admin->setFirstname('Admin');
        $admin->setNombrePersonne('0');
        $admin->setTelnum('0600000000');
        $admin->setAllergies('Poissons');
        $admin->setPassword(
            $this->passwordEncoder->hashPassword($admin, '123456')
        );
        $admin->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);

        $faker = Faker\Factory::create('fr_FR');

        for($usr = 1; $usr <= 5; $usr++){
            $user = new User();
            $user->setEmail($faker->email);
            $user->setLastname($faker->lastName);
            $user->setFirstname($faker->firstName);
            $user->setNombrePersonne($faker->randomDigitNotNull());
            $user->setTelnum($faker->mobileNumber());
            $user->setAllergies($faker->word());
            $user->setPassword(
                $this->passwordEncoder->hashPassword($user, 'secret')
            );
            $manager->persist($user);
        }

        $manager->flush();
    }

}
