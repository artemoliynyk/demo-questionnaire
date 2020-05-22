<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ProfileFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'First name',
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Last name',
            ])
            ->add('email', EmailType::class,
                [
                    'label' => 'form.email',
                    'translation_domain' => 'FOSUserBundle',
                ]
            )
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'options' => [
                    'translation_domain' => 'FOSUserBundle',
                    'attr' => [
                        'autocomplete' => 'new-password',
                    ],
                ],
                'first_options' => [
                    'label' => 'form.password',
                ],
                'second_options' => [
                    'label' => 'form.password_confirmation',
                ],
                'invalid_message' => 'fos_user.password.mismatch',
                'required' => false,
            ])

            // no username
            ->remove('username')
        ;
    }

    public function getParent()
    {
        return \FOS\UserBundle\Form\Type\ProfileFormType::class;
    }
}
