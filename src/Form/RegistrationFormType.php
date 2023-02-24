<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control my-3'
                ]
            ])
            ->add('firstName', TextType::class, [
                'attr' => [
                    'class' => 'form-control my-3'
                ],
                'constraints' => [
                    new Regex([
                        'pattern'=> '^[a-zA-Z]+$^',
                        'message' => 'Le prénom doit contenir que des lettres'
                    ]),
                ],
                'required' => false
            ])
            ->add('allergyList', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control my-3'
                ],
                'constraints' => [
                    new Regex([
                        'pattern'=> '^[a-zA-Z]+$^',
                        'message' => 'La liste d\'allergies peut contenir que des lettres'
                    ]),
                ],
                'required' => false
            ])
            ->add('guestQuantity', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control my-3'
                ],
                'constraints' => [
                    new Positive([
                        'message' => 'Vous devez indiquer un entier positif'
                    ]),
                ],
                'required' => false
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'attr' => [
                    'class' => 'form-check-input my-1 mx-2'
                ],
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => [
                    'class' => 'form-control my-3',
                    'autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci d\'indiquer le mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Le mot de passe doit contenir un minimum de {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
