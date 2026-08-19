<?php

namespace App\Form;

use App\Entity\Parfum;
use App\Entity\ParfumVariant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParfumVariantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('parfum', EntityType::class, [
                'label' => 'Parfum',
                'class' => Parfum::class,
                'choice_label' => 'name',
            ])

            ->add('size', ChoiceType::class, [
                'label' => 'Contenance',
                'placeholder' => '-- Choisir une contenance --',
                'choices' => [
                    '35 ml' => '35 ml',
                    '50 ml' => '50 ml',
                    '70 ml' => '70 ml',
                    '100 ml' => '100 ml',
                    '200 ml' => '200 ml'
                ],
            ])

            ->add('price', MoneyType::class, [
                'label' => 'Prix',
                'currency' => 'EUR',
            ])

            ->add('image', TextType::class, [
                'label' => 'Image',
                'required' => false,
                'attr' => [
                    'placeholder' => "Laisser vide pour utiliser l'image du parfum"
                ],
            ])

            ->add('stock', IntegerType::class, [
                'label' => 'Stock',
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ParfumVariant::class,
        ]);
    }
}