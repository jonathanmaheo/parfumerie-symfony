<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'label_html' => true,
                'required' => false,
                'attr' => [
                    'placeholder' => 'saisir votre email',
                ],
                'constraints' => [
                    new NotBlank ([
                        'message' => 'Veuillez saisir votre email'
                    ]),
                    new Email ([
                        'message' => 'Veuillez saisir un email conforme'
                    ])
                ]
            ])

            ->add('firstname', null, [
                'label' =>'Prenom<span class="text-danger">*</span>',
                'label_html' => true,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Saisir votre prenom'
                ],
                'constraints' => [
                    new NotBlank ([
                        'message' => 'Veuillez saisir votre prenom'
                    ])
                ]
            ])

            ->add('lastname', null, [
                'label' => 'Nom<span class="text-danger">*</span>',
                'label_html' => true,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Saisir votre nom'
                ],
                'constraints' => [
                    new NotBlank ([
                        'message' => 'Veuillez saisir votre nom'
                    ])
                ]
            ])

            ->add('agreeTerms', CheckboxType::class, [
                'label' => 'J\'accepte les conditions générales d\'utilisation',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new IsTrue(
                        message: 'Veuillez accepter les conditions générales d\'utilisation',
                    ),
                ],
            ])

            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,

                'invalid_message' => 'Les mots de passe ne sont pas identiques',

                'options' => [

                    'constraints' => [
                        new NotBlank([
                            'message' => 'Veuillez saisir un mot de passe'
                        ]),
                        new Regex([
                            'pattern' => '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[-+!*$@%_?.])([-+!*$@%_?.\w]{6,})$/',
                            'match' => true,
                            'message' => 'Votre mot de passe doit contenir au moins 1 lettre en majuscule, 1 lettre en minuscule, 1 chiffre et un des caractères spéciaux suivants :  - + ! . * $ @ % _ ?  '
                        ]),
                    ],
                    
                    
                ],
                'mapped' => false,
                'required' => false,
                'first_options'  => [
                    'label' => 'Mot de passe<span class="text-danger">*</span>',
                    'label_html' => true,
                    'attr' => [
                        'placeholder' => 'Saisir un mot de passe',
                    ],
                    'help' => 'Votre mot de passe doit contenir au moins 1 lettre en majuscule, 1 lettre en minuscule, 1 chiffre et un des caractères spéciaux suivants : <span class="text-primary"> - + ! * $ @ % _ ?</span>',
                    'help_html' => true
                ],
                'second_options' => [
                    'label' => 'Confirmation du mot de passe<span class="text-danger">*</span>',
                    'label_html' => true,
                    'attr' => [
                        'placeholder' => 'Confirmer votre mot de passe',
                    ],
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
