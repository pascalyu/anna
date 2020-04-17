<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\DBAL\Types\DecimalType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['label' => "Nom du produit"])
            ->add('description', TextareaType::class, ['label' => "Description du produit"])
            ->add('price', NumberType::class, ['label' => "Prix"])
            ->add('quantity', IntegerType::class, ['label' => "Quantité en stock"])
            ->add(
                'category',
                EntityType::class,
                [
                    'label' => 'Catégorie',
                    'class' => Category::class,
                    'choice_label' => 'name'
                ]
            )
            ->add('pictures', CollectionType::class, array(
                'entry_type' => PictureType::class,
                'allow_add' => true,
                'attr' => ['']

            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
