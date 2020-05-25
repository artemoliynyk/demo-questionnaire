<?php

namespace App\Form;

use App\Entity\Question;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
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

        $builder->add('responses', CollectionType::class, [
            'entry_type' => ResponseType::class,
            'required' => false,
        ]);
    }

    public function getBlockPrefix()
    {
        return 'response_page';
    }
}
