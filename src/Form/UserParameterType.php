<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserParameterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,

                'invalid_message' => 'Le mot de passe doit être le même.',
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'options' => array('attr' => array('class' => 'password-field')),
                'first_options' => array('label' => 'Mot de passe'),
                'second_options' => array('label' => 'Confirmé le mot de passe'),
                'required' => false,
                'constraints' => [
                    
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Le mot de passe doit avoir au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add(
                'shipping_address',
                AddressType::class,
                [
                    'label' => "Adresse de livraison",
                    'attr' => ['class' => 'card p-2 border border-dark']
                ]
            )
            ->add('billing_address', AddressType::class, [
                'label' => "Adresse de facturation",
                'attr' => ['class' => 'card p-2 border border-dark']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
