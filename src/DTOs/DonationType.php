<?php

namespace App\DTOs;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;

class DonationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class,
                [
                    'attr' => ['placeholder' => 'FIRST NAME']
                ])
            ->add('lastName', TextType::class,
                [
                    'attr' => ['placeholder' => 'LAST NAME']
                ])
            ->add('mailAddress', EmailType::class,
                [
                    'attr' => ['placeholder' => 'E-MAIL ADDRESS']
                ])
            ->add('phoneNumber', TelType::class,
                [
                    'attr' => ['placeholder' => 'PHONE NUMBER']
                ])
            ->add('description', TextType::class,
                [
                    'required' => false,
                    'attr' => ['placeholder' => 'DESCRIPTION']
                ])
            ->add('imageFiles', FileType::class,
                [
                    'multiple' => true,
                ])
            ->add('public', CheckboxType::class,
                [
                    'required' => false
                ])
            ->add('submit', SubmitType::class);
    }
}