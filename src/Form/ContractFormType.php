<?php

namespace App\Form;

use App\Entity\Contract;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ContractFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                "label" => 'Nom',
                'attr' => ["placeholder" => 'Nom', 'class' => "mb-3"]
            ])
            ->add("submit", SubmitType::class, [
                "label" => 'Valider',
                'attr' => ['class' => "btn bg-color-primary"]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contract::class,
        ]);
    }
}
