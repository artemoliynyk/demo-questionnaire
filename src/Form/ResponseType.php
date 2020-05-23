<?php

namespace App\Form;

use App\Entity\Answer;
use App\Entity\Response;
use App\Repository\AnswerRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResponseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var Response $data */
        $data = $options['data'];

        $builder->add('answer', EntityType::class, [
            'class' => Answer::class,
            'expanded' => true,
            'multiple' => false,
            'query_builder' => function (AnswerRepository $repository) use ($data) {
                return $repository->createQueryBuilder('a')
                    ->where('a.question = :question')
                    ->setParameter('question', $data->getQuestion())
                    ;
            },
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Response::class,
        ]);
    }
}
