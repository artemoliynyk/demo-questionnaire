<?php

namespace App\Repository;

use App\Entity\Question;
use App\Entity\Response;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method Response|null find($id, $lockMode = null, $lockVersion = null)
 * @method Response|null findOneBy(array $criteria, array $orderBy = null)
 * @method Response[]    findAll()
 * @method Response[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResponseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Response::class);
    }

    public function getOrCreateResponse(UserInterface $user, Question $question)
    {
        $qb = $this->createQueryBuilder('r');
        $qb->select('r')
            ->where('r.user = :user')
            ->andWhere('r.question = :question')
            ->setParameters([
                'user' => $user,
                'question' => $question,
            ])
            ->setMaxResults(1)
        ;

        $result = $qb->getQuery()->getOneOrNullResult();
        $response = $result ?? new Response($question);
        $response->setUser($user);

        return $response;
    }

    public function getQuestionAverages(Question $question)
    {
        $qb = $this->createQueryBuilder('r');
        $qb->select($qb->expr()->avg('a.weight'))
            ->leftJoin('r.answer', 'a')
            ->where('r.question = :question')
            ->setParameters([
                'question' => $question,
            ])
            ->setMaxResults(1)
        ;

        return (int) $qb->getQuery()->getSingleScalarResult();
    }
}
