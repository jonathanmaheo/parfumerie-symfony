<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class ChangePasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
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
        $resolver->setDefaults([]);
    }
}
