<?php

namespace App\Form;

use App\Entity\Answer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnswerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('answerText', TextType::class, [
                'required' => true,
                'label' => 'Text',
            ])
            ->add('weight', IntegerType::class, [
                'required' => true,
                'attr' => [
                    'min' => 0,
                    'max' => 5,
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Answer::class,
            'label' => 'Answer',
        ]);
    }

    public function getBlockPrefix()
    {
        return 'answer';
    }


}
