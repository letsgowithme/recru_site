<?php

namespace App\Form;

use App\Entity\Apply;
use App\Entity\Notification;
use App\Repository\ApplyRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NotificationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('apply', EntityType::class, [
                'class' => Apply::class,
                'query_builder' => function (ApplyRepository $a) {
                    return $a->createQueryBuilder('a')
                            //  ->where('a.isApproved = true')
                             ->orderBy('a.id', 'ASC');
                },
                'attr' => [
                    'class' => 'mb-4'
                ],
                'label' => 'Postulé',
                'label_attr' => [
                    'class' => 'form-label mt-4 mb-4 text-dark fs-5'
                ],

                // 'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Notification::class,
        ]);
    }
}
