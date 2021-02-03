<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Data\SearchProductData;
use App\Entity\Category;
use App\Entity\Gender;

class SearchFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('q', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Recherche rapide'
                    ]
            ])

            ->add('gender', EntityType::class, [
                'label' => false,
                'choice_label' => 'name',
                'required' => false,
                'class' => Gender::class,
                'expanded' => true,
                'multiple' => true
            ])

            ->add('category', EntityType::class, [
                'label' => false,
                'choice_label' => 'name',
                'required' => false,
                'class' => Category::class,
                'expanded' => true,
                'multiple' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchProductData::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
