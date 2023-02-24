<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\Regex;

class UserUpdateFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
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
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}