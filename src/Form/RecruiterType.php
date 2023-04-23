<?php

namespace App\Form;

use App\Entity\Company;
use App\Entity\User;
use App\Repository\CompanyRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecruiterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('company', EntityType::class, [
            'attr' => [
                'class' => 'form-control'
            ],
            'label' => 'Companie',
            'class' => Company::class,
            'query_builder' => function (CompanyRepository $r) {
                return $r->createQueryBuilder('i')
                    ->orderBy('i.title', 'ASC');
            },
            'choice_label' => 'Title',
            'required' => false,
            'multiple' => false,
            // 'expanded' => true
        ])
        ->add('submit', SubmitType::class, [
            'attr' => [
                'class' => 'btn btn-primary mt-4'
            ],
             'label' => 'Enregistrer'
    ])
        ;
        
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
