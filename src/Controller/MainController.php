<?php

namespace App\Controller;

use App\Repository\QuestionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(QuestionRepository $questionRepository)
    {
        $questions = $questionRepository->findAll();

        return $this->render('main/index.html.twig', [
            'questions' => $questions,
        ]);
    }
}
