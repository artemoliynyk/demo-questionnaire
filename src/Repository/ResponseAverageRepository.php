<?php

namespace App\Repository;

use App\Entity\Question;
use App\Entity\ResponseAverage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ResponseAverage|null find($id, $lockMode = null, $lockVersion = null)
 * @method ResponseAverage|null findOneBy(array $criteria, array $orderBy = null)
 * @method ResponseAverage[]    findAll()
 * @method ResponseAverage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResponseAverageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ResponseAverage::class);
    }

    public function getOrCreateAverage(Question $question): ?ResponseAverage
    {
        $qb = $this->createQueryBuilder('ra');

        $qb->select('ra')
            ->where('ra.question = :question')
            ->setParameter('question', $question)
        ;

        $result = $qb->getQuery()->getOneOrNullResult();

        $responseAverage = $result ?? new ResponseAverage($question);
        $responseAverage->setQuestion($question);

        return $responseAverage;
    }

}
