<?php

namespace App\DataFixtures;

use App\Entity\Question;
use App\Entity\Response;
use App\Entity\User;
use App\Repository\QuestionRepository;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class C_ResponseFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        /** @var UserRepository $questionRepo */
        $userRepo = $manager->getRepository(User::class);
        $users = $userRepo->findAll();

        /** @var QuestionRepository $questionRepo */
        $questionRepo = $manager->getRepository(Question::class);
        $questions = $questionRepo->findAll();

        foreach ($users as $user) {
            foreach ($questions as $question) {
                $answersCnt = $question->getAnswers()->count();
                $answer = $question->getAnswers()->get(rand(0, $answersCnt-1));

                $response = new Response($question);
                $response->setUser($user);
                $response->setAnswer($answer);

                $manager->persist($response);
            }

            $manager->flush();
        }
    }
}
