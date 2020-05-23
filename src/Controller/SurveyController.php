<?php

namespace App\Controller;

use App\Form\ResponsePageType;
use App\Repository\QuestionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SurveyController extends AbstractController
{
    /**
     * @Route("/survey", name="survey")
     */
    public function survey(Request $request, QuestionRepository $questionRepository)
    {
        $questions = $questionRepository->findAll();
        $question = reset($questions);

//        $responses = new ArrayCollection();
//        foreach ($questions as $question) {
//            $response = new Response($question);
//            $response->setUser($this->getUser());
//            $responses->add($response);
//        }

//        $form = $this->createForm(ResponseType::class, $response);
        $form = $this->createForm(ResponsePageType::class, $questions);
//        $form = $this->createForm(ResponsePageType::class, ['responses' => $responses]);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($question);
                $entityManager->flush();

                $this->addFlash('success', 'Entry created');

                return $this->redirectToRoute('question_index');
            } else {
                $this->addFlash('error', 'An error occurred, please check form values');
            }
        }

        return $this->render('survey/index.html.twig', [
            'questions' => $questions,
            'form' => $form->createView(),
        ]);
    }
}
