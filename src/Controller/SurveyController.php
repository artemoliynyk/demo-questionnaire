<?php

namespace App\Controller;

use App\Form\ResponsePageType;
use App\Repository\QuestionRepository;
use App\Repository\ResponseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SurveyController extends AbstractController
{
    /**
     * @var QuestionRepository
     */
    private $questionRepository;

    /**
     * @var ResponseRepository
     */
    private $responseRepository;

    public function __construct(QuestionRepository $questionRepository, ResponseRepository $responseRepository)
    {
        $this->questionRepository = $questionRepository;
        $this->responseRepository = $responseRepository;
    }

    /**
     * @Route("/survey", name="survey")
     * @Route("/survey/{page}", name="survey", requirements={"page"="1|2"})
     */
    public function survey(Request $request, $page = 1)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $questions = $this->questionRepository->getForPage($page);

        $responses = new ArrayCollection();
        foreach ($questions as $question) {
            $response = $this->responseRepository->getOrCreateResponse($this->getUser(), $question);
            $responses->add($response);
        }

        $form = $this->createForm(ResponsePageType::class, ['responses' => $responses]);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                foreach ($responses as $response) {
                    $entityManager->persist($response);
                }
                $entityManager->flush();

                if ($page == 1) {
                    return $this->redirectToRoute('survey', ['page' => 2]);
                } else {
                    return $this->redirectToRoute('survey_results');
                }
            } else {
                $this->addFlash('error', 'An error occurred, please check form values');
            }
        }

        return $this->render('survey/index.html.twig', [
            'questions' => $questions,
            'form' => $form->createView(),
            'page' => $page,
        ]);
    }

    /**
     * @Route("/survey-results", name="survey_results")
     */
    public function resultsAction(ResponseRepository $responseRepository, QuestionRepository $questionRepository)
    {
        $userResponses = $responseRepository->getUserResponses($this->getUser());
        $responsesPerQuestion = $responseRepository->getResponsesPerQuestion();

        return $this->render('survey/results.html.twig', [
            'user_responses' => json_encode($userResponses),
            'chart_data' => json_encode($responsesPerQuestion),
        ]);
    }

}
