<?php

namespace App\Form;

use App\Entity\Company;
use App\Entity\Job;
use App\Repository\CompanyRepository;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class JobType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'L\'intitulé du post',
                'label_attr' => [
                    'class' => 'form-label mt-4 text-dark fs-5',
                    'minLength' => '2',
                    'maxLength' => '255'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 255]),
                    new Assert\NotBlank()
                ]
            ])
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
                'multiple' => false,
                'expanded' => true
            ])
            // ->add('company', TextType::class, [
            //     'attr' => [
            //         'class' => 'form-control'
            //     ],
            //     'label' => 'Companie',
            //     'label_attr' => [
            //         'class' => 'form-label mt-4 text-dark fs-5',
            //         'minLength' => '2',
            //         'maxLength' => '255'
            //     ],
            //     'constraints' => [
            //         new Assert\Length(['min' => 2, 'max' => 255]),
            //         new Assert\NotBlank()
            //     ]
            // ])
            // ->add('location', CKEditorType::class, [
            //     'attr' => [
            //         'class' => 'form-control'
            //     ],
            //     'label' => 'Adresse',
            //     'label_attr' => [
            //         'class' => 'form-label mt-4 text-dark fs-5'
            //     ],
            //     'constraints' => [
            //         new Assert\NotBlank()
            //     ]
            // ])
            ->add('description', CKEditorType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Description',
                'label_attr' => [
                    'class' => 'form-label mt-4 text-dark fs-5'
                ],
                'constraints' => [
                    new Assert\NotBlank()
                ]
            ])
            ->add('salary')
            ->add('schedule', CKEditorType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Horaires',
                'label_attr' => [
                    'class' => 'form-label mt-4 text-dark fs-5'
                ],
                'constraints' => [
                    new Assert\NotBlank()
                ]
            ])
            ->add('isApproved', CheckboxType::class, [
                'attr' => [
                    'class' => 'form-check-input mt-4 mb-4',
                ],
                'required' => false,
                'label' => 'Approuvé ? ',
                'label_attr' => [
                    'class' => 'form-check-label mt-3 ms-3 text-dark fs-5 mb-4'
                ],
                'constraints' => [
                    new Assert\NotNull()
                ]
            ])
            ->add('isPublished', CheckboxType::class, [
                'attr' => [
                    'class' => 'form-check-input mt-4 mb-4',
                ],
                'required' => false,
                'label' => 'Publié ? ',
                'label_attr' => [
                    'class' => 'form-check-label mt-3 ms-3 text-dark fs-5 mb-4'
                ],
                'constraints' => [
                    new Assert\NotNull()
                ]
            ])
           
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary mt-4 mb-4 fs-5'
                ],
                'label' => 'Sauvegarder'  
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Job::class,
        ]);
    }
}
