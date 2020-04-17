<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,['label'=>"Nom & Prénom"])
            ->add('street_name',TextType::class,['label'=>"Numéro et Nom de rue"])
            ->add('zip_code',TextType::class,['label'=>"Code postal"])
            ->add('city',TextType::class,['label'=>"Ville"])
            ->add('country',TextType::class,['label'=>"Pays"])
            ->add('more_information',TextType::class,['label'=>"Information complémentaire"])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
