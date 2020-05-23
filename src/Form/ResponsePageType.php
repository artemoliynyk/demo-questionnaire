<?php

namespace App\Form;

use App\Entity\Question;
use App\Entity\Response;
use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Security\Core\Security;

class ResponsePageType extends AbstractType
{
    /**
     * @var User
     */
    private $user;

    public function __construct(Security $security)
    {
        $this->user = $security->getUser();
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var Question[] $questions */
        $questions = $options['data'];


        $responses = new ArrayCollection();
        foreach ($questions as $question) {
            $response = new Response($question);
            $response->setUser($this->user);

            $responses->add($response);
        }


        $builder->add('responses', CollectionType::class, [
            'data_class' => ResponseType::class,
        ]);

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            /** @var Question[] $questions */
            $questions = $event->getData();
            $form = $event->getForm();

            $responses = new ArrayCollection();

            foreach ($questions as $question) {
                $response = new Response($question);
                $response->setUser($this->user);

                $responses->add($response);
            }

            $form->get('responses')->setData($responses);
        });
    }
}
