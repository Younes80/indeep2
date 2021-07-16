<?php

namespace App\Form;

use App\Entity\Contract;
use App\Entity\ContractType;
use App\Entity\Offer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class OfferFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                "label" => 'Titre',
                'attr' => ["placeholder" => 'Titre', 'class' => "mb-3"]
            ])
            ->add('company', TextType::class, [
                "label" => 'Société',
                'attr' => ["placeholder" => 'Société', 'class' => "mb-3"]
            ])
            ->add('city', TextType::class, [
                "label" => 'Ville',
                'attr' => ["placeholder" => 'Ville', 'class' => "mb-3"]
            ])
            ->add('description', TextareaType::class, [
                "label" => "Description de l'offre",
                'attr' => ["placeholder" => "Description de l'offre", 'class' => "mb-3"]
            ])
            ->add('contract', EntityType::class, [
                "class" => Contract::class,
                'label' => 'Contrat',
                'choice_label' => 'name',
                'choice_attr' => ['attr' => ['class' => "d-flex"]],
                'multiple' => false,
                'expanded' => false,
                'attr' => ['class' => "d-flex flex-wrap align-items-center mb-3"]
            ])
            ->add('contractType', EntityType::class, [
                "class" => ContractType::class,
                'label' => 'Type de contrat',
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'attr' => ['class' => "d-flex justify-content-evenly align-items-center mb-3"]
            ])
            ->add("submit", SubmitType::class, [
                "label" => 'Valider',
                'attr' => ['class' => "btn bg-color-primary"]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Offer::class,
        ]);
    }
}
