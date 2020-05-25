<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class B_UserFixtures extends Fixture
{
    /**
     * @var string[]
     */
    private $firstnames;

    /**
     * @var string[]
     */
    private $lastnames;

    public function __construct()
    {

        $this->firstnames = [
            'Noah',
            'Liam',
            'Jackson',
            'Lucas',
            'Logan',
            'Benjamin',
            'Jacob',
            'William',
            'Oliver',
            'James',
            'Olivia',
            'Emma',
            'Charlotte',
            'Sophia',
            'Aria',
            'Ava',
            'Chloe',
            'Zoey',
            'Abigail',
            'Amilia',

            'Francesco',
            'Alessandro',
            'Mattia',
            'Lorenzo',
            'Leonardo',
            'Andrea',
            'Gabriele',
            'Matteo',
            'Tommaso',
            'Riccardo',
        ];

        $this->lastnames = [
            'Smith',
            'Johnson',
            'Williams',
            'Brown',
            'Jones',
            'Miller',
            'Davis',
            'Garcia',
            'Rodriguez',
            'Wilson',
            'Martinez',
            'Anderson',
            'Taylor',
            'Thomas',
            'Hernandez',
            'Moore',
            'Martin',
            'Jackson',
            'Thompson',
            'White',
            'Lopez',
            'Lee',
            'Gonzalez',
            'Harris',
            'Clark',
            'Lewis',
            'Robinson',
            'Walker',
        ];
    }


    public function load(ObjectManager $manager)
    {
        // create users
        for ($i = 1; $i <= 25; $i++) {
            $user = new User();

            $firstname = $this->firstnames[array_rand($this->firstnames, 1)];
            $lastname = $this->lastnames[array_rand($this->lastnames, 1)];

            $email = strtolower("{$firstname}{$lastname}{$i}@example.com");

            $user->setEmail($email);
            $user->addRole('ROLE_USER');

            $user->setFirstName($firstname);
            $user->setLastName($lastname);

            $user->setPlainPassword('12345');
            $user->setEnabled(true);

            $manager->persist($user);
        }

        $manager->flush();

    }
}
