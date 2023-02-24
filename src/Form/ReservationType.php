<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\Regex;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control my-3'
                ],
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
            ->add('guestQuantity', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control my-3'
                ],
                'constraints' => [
                    new Positive([
                        'message' => 'Vous devez indiquer un entier positif'
                    ]),
                ],
            ])
            ->add('allergyList', TextType::class, [
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
            ->add('reservationDay', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control my-3',
                    'min' => (new \DateTime('now'))->format('Y-m-d'),
                ],
            ])
            ->add('reservationTime', TextType::class, [
                'attr' => [
                    'class' => 'form-control my-3',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
