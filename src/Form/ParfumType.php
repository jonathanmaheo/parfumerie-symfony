<?php

namespace App\Form;

use App\Entity\Brand;
use App\Entity\Family;
use App\Entity\Parfum;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\Url;

class ParfumType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du parfum',
                'attr' => [
                    'placeholder' => '--Veuillez saisir le nom du parfum--'
                ],
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir le nom du parfum'
                    ])
                ]
            ])

            ->add('brand', EntityType::class, [
                'label' => 'Marque',
                'class' => Brand::class,
                'choice_label' => 'title',
            ])

            // ->add('price', MoneyType::class, [
            //     'label' => 'Prix<span class="text-danger">*</span>',
            //     'label_html' => true,
            //     'attr' => [
            //         'placeholder' => 'Saisir un prix',
            //     ],
            //     'required' => false,
            //     'constraints' => [
            //         new NotBlank([
            //             'message' => 'Veuillez saisir le prix'
            //         ]),
            //         new Positive([
            //             'message' => 'Veuillez saisir un prix strictement supérieur à 0'
            //         ])
            //     ]
            // ])

            ->add('families', EntityType::class, [
                'label' => 'Familles olfactives',
                'class' => Family::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
                'required' => false,
            ])

            ->add('type', ChoiceType::class, [
                'label' => 'Type de parfum<span class="text-danger">*</span>',
                'label_html' => true,
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir le type du parfum'
                    ])
                ],
                'placeholder' => '--Saisir le type de parfum--',
                'choices' => [
                    'Eau de toilette' => 'Eau de toilette',
                    'Eau de parfum' => 'Eau de parfum',
                    'Extrait de parfum' => 'Extrait de parfum',
                    'Esprit de parfum' => 'Esprit de parfum',
                ]
            ])

            ->add('picture', UrlType::class, [
                'label' => 'Photo',
                'label_html' => true,
                'required' => false,
                'constraints' => [
                    new Url([
                        'message' => 'Veuillez saisir un lien correct'
                    ])
                ],
                'attr' => [
                    'placeholder' => "--Saisir le lien de l'image--"
                ]
            ])

            ->add('noteTete', TextareaType::class, [
                'label' => 'Note de tête',
                'required' => false,
            ])

            ->add('noteCoeur', TextareaType::class, [
                'label' => 'Note de cœur',
                'required' => false,
            ])

            ->add('noteFond', TextareaType::class, [
                'label' => 'Note de fond',
                'required' => false,
            ])

            ->add('sillage', IntegerType::class, [
                'label' => 'Sillage',
                'required' => false,
                'attr' => [
                    'min' => 0,
                    'max' => 100,
                    'placeholder' => 'Ex : 80'
                ],
            ])

            ->add('tenue', IntegerType::class, [
                'label' => 'Tenue',
                'required' => false,
                'attr' => [
                    'min' => 0,
                    'max' => 100,
                    'placeholder' => 'Ex : 90'
                ],
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Parfum::class,
        ]);
    }
}