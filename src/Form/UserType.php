<?php

namespace App\Form;

use App\Entity\Company;
use App\Entity\User;

use App\Repository\CompanyRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('firstname', TextType::class, [
            'attr' => [
                'class' => 'form-control'
            ],
            'label' => 'Prénom',
            'label_attr' => [
                'class' => 'form-label  mt-4'
            ],
          
        ])
            ->add('lastname', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Nom',
                'label_attr' => [
                    'class' => 'form-label  mt-4'
                ]
             
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minLength' => '2',
                    'maxLength' => '180'
                ],
                'label' => 'Email',
                'label_attr' => [
                    'class' => 'form-label mt-4',
                    
                ],
                'constraints' => [
                    // new Assert\Length(['min' => 2, 'max' => 180]),
                    new Assert\Email(),
                    new Assert\NotBlank()
                ]
            ])
            ->add('roles', ChoiceType::class, [
                'attr' => [
                    'class' => 'form-control ms-4 mb-4'
                ],
                'multiple' => true,
                'choices'  => [
                    // 'Utilisateur' => 'ROLE_USER',
                    'Candidat' => 'ROLE_CAND',
                    'Recruteur' => 'ROLE_RECR',
                    'Consultant' => 'ROLE_CONS',
                    // 'Admin' => 'ROLE_ADMIN'
                ]
            ])
            ->add('plainPassword', PasswordType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Mot de passe',
                'label_attr' => [
                    'class' => 'form-label  mt-4'
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
                        ->orderBy('i.name', 'ASC');
                },
                'choice_label' => 'Companie',
                'multiple' => false,
                'expanded' => true
            ])
            
            // ->add('location', TextareaType::class, [
            //     'attr' => [
            //         'class' => 'form-control'
            //     ],
            //     'label' => 'Adresse',
            //     'label_attr' => [
            //         'class' => 'form-label  mt-4'
            //     ]
            // ])

            // ->add('isVerfied', CheckboxType::class, [
            //     'attr' => [
            //         'class' => 'form-check-input mt-4 mb-4',
            //     ],
            //     'required' => false,
            //     'label' => 'Demande vérifiée ? ',
            //     'mapped' => false,
            //     'label_attr' => [
            //         'class' => 'form-check-label mt-3 ms-3 text-dark fs-5'
            //     ]
               
            // ])
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
