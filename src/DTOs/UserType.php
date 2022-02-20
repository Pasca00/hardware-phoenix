<?php

namespace App\DTOs;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('mailAddress', EmailType::class,
                [
                    'attr' => ['placeholder' => 'E-MAIL ADDRESS']
                ])
            ->add('password', PasswordType::class,
                [
                    'attr' => ['placeholder' => 'PASSWORD']
                ])
            ->add('confirmPassword', PasswordType::class,
                [
                    'mapped' => false,
                    'attr' => ['placeholder' => 'CONFIRM PASSWORD']
                ])
            ->add('firstName', TextType::class,
                [
                    'attr' => ['placeholder' => 'FIRST NAME']
                ])
            ->add('lastName', TextType::class,
                [
                    'attr' => ['placeholder' => 'LAST NAME']
                ])
            ->add('submit', SubmitType::class);
    }
}