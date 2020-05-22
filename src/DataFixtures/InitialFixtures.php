<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class InitialFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $admin = new User();
        $admin->setEmail('admin@example.com');
        $admin->addRole('ROLE_ADMIN');
        $admin->setFirstName('Joe');
        $admin->setLastName('Bloggs');

        $admin->setPlainPassword('admin123');
        $admin->setEnabled(true);

        $manager->persist($admin);

        $manager->flush();
    }
}
