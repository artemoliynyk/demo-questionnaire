<?php

namespace App\DataFixtures;

use App\Entity\Answer;
use App\Entity\Question;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class InitialFixtures extends Fixture
{
    private $questions = [
        "What is your favorite product?",
        "Why did you purchase this product?",
        "How satisfied are you with Super Acme 2000 ®?",
        "Would you recommend Super Acme 2000 ® to a friend?",
        "Would you recommend AcmeCorp. to a friend?",
        "If you could change one thing about Super Acme 2000 ®, what would it be?",
        "Which other options were you considering before Super Acme 2000 ®?",
        "Did Super Acme 2000 ® help you accomplish your goal?",
        "What's the primary reason for canceling your account?",
        "How satisfied are you with our customer support?",
    ];

    private $answers = [
        'Yes',
        'No',
        'Maybe',
        'Sometimes',
        'Never',
        'Always',
        'For sure',
        'It depends',
        'Not sure',
        'Other',
    ];

    public function load(ObjectManager $manager)
    {
        // create admin
        $admin = new User();
        $admin->setEmail('admin@example.com');
        $admin->addRole('ROLE_ADMIN');
        $admin->setFirstName('Joe');
        $admin->setLastName('Bloggs');

        $admin->setPlainPassword('admin123');
        $admin->setEnabled(true);

        $manager->persist($admin);


        // create demo questions
        shuffle($this->questions);

        foreach ($this->questions as $questionText) {
            $question = new Question();
            $question->setQuestionText($questionText);

            shuffle($this->answers);
            $answersNumber = rand(2, 6);
            for ($a = 1; $a <= $answersNumber; $a++) {
                $answer = new Answer();
                $answer->setAnswerText($this->answers[$a]);
                $answer->setWeight($a);

                $question->addAnswer($answer);
            }

            $manager->persist($question);
        }

        $manager->flush();


    }
}
