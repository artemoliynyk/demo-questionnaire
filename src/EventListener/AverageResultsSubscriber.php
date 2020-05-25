<?php
/**
 * Artem Oliynyk, <artem@readmire.com>
 * Date: 25/05/20
 */

namespace App\EventListener;


use App\Entity\Response;
use App\Entity\ResponseAverage;
use App\Repository\ResponseAverageRepository;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class AverageResultsSubscriber implements EventSubscriber
{
    public function getSubscribedEvents()
    {
        return [
            Events::postPersist,
            Events::postUpdate,
        ];
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $this->processResponses($args);
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->processResponses($args);
    }

    public function processResponses(LifecycleEventArgs $args)
    {
        /** @var Response $entity */
        $entity = $args->getObject();

        if ($entity instanceof Response) {
            $objectManager = $args->getObjectManager();

            $question = $entity->getQuestion();

            $responseRepo = $objectManager->getRepository(Response::class);
            $questionAverage = $responseRepo->getQuestionAverages($question);

            /** @var ResponseAverageRepository $responseAverageRepo */
            $responseAverageRepo = $objectManager->getRepository(ResponseAverage::class);

            $responseAverage = $responseAverageRepo->getOrCreateAverage($question);
            $responseAverage->setAverage($questionAverage);

            $objectManager->persist($responseAverage);
            $objectManager->flush();
        }
    }

}