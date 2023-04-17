<?php

namespace App\Form;

use App\Entity\Company;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompanyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Titre',
                'label_attr' => [
                    'class' => 'form-label  mt-4'
                ],
              
            ])
           
            ->add('location', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Adresse',
                'label_attr' => [
                    'class' => 'form-label  mt-4'
                ]
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Company::class,
        ]);
    }
}
