<?php

namespace App\Form;

use App\Entity\Role;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class,  [
                "label" => 'Prénom',
                'attr' => ["placeholder" => 'Prénom', 'class' => "mb-3"]
            ])
            ->add('lastName', TextType::class,  [
                "label" => 'Nom',
                'attr' => ["placeholder" => 'Nom', 'class' => "mb-3"]
            ])
            ->add('email', TextType::class,  [
                "label" => 'Email',
                'attr' => ["placeholder" => 'Email', 'class' => "mb-3"]
            ])
            ->add('role', EntityType::class, [
                "class" => Role::class,
                'label' => 'Role',
                'choice_label' => 'name',
                'choice_attr' => ['attr' => ['class' => "d-flex"]],
                'multiple' => false,
                'expanded' => false,
                'attr' => [
                    'class' => "d-flex flex-wrap align-items-center mb-3"
                ]
            ])
            // ->add('roles')
            ->add('password', PasswordType::class,  [
                "label" => 'Mot de passe',
                'attr' => ["placeholder" => 'Mot de passe', 'class' => "mb-3"]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
