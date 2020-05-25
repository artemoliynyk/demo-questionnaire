<?php

namespace App\Form;

use App\Entity\Answer;
use App\Entity\Response;
use App\Repository\AnswerRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResponseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(
            FormEvents::POST_SET_DATA,
            function (FormEvent $event) {
                $form = $event->getForm();

                /** @var Response $data */
                $data = $form->getData();

                $form->add('answer', EntityType::class, [
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
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Response::class,
        ]);
    }

    public function getBlockPrefix()
    {
        return "response_answers";
    }
}
