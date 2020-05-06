<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('searchbar', SearchType::class, ['label' => "Recherche", 'required' => false])
            ->add(
                'category',
                EntityType::class,
                [
                    'label' => 'Catégorie',
                    'placeholder' => "Tout",
                    'class' => Category::class,
                    'choice_label' => 'name',
                    'choice_value' => 'id', 'required' => false
                ]
            )
            ->add('minPrice', MoneyType::class, [
                'label' => false,
                'currency' => false,
                'required' => false,
                'attr' => ['placeholder' => 'Min €','class'=>'']
            ])
            ->add('maxPrice', MoneyType::class, [
                'label' => false,
                'currency' => false,
                'required' => false,
                'attr' => ['placeholder' => 'Max €','class'=>'']
            ])
            ->add('rechercher', SubmitType::class, [
                'label' => 'Rechercher',
                'attr' => ['class' => 'form-control btn primaryColor text-white'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
