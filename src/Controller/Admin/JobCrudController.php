<?php

namespace App\Controller\Admin;

use App\Entity\Job;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class JobCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Job::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig')
            ->setEntityLabelInSingular('Emploi')
            ->setEntityLabelInPlural('Emplois')
            ->setPageTitle(pageName: Crud::PAGE_INDEX, title: 'Emplois')
            ->setPageTitle(pageName: Crud::PAGE_NEW, title: 'Créer une Emplois')
            ->setPageTitle(pageName: Crud::PAGE_EDIT, title: 'Modifier l\'Emploi');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
            ->hideOnForm(),
            TextField::new('title')
                ->setLabel('L\'intitulé'),
            TextField::new('company')
                ->setLabel('Companie'),
            TextEditorField::new('location')
                ->setLabel('Adresse')
                ->setFormType(CKEditorType::class)
                ->hideOnIndex(),
            TextEditorField::new('description')
                ->setLabel('Déscription')
                ->setFormType(CKEditorType::class)
                ->hideOnIndex(),
            NumberField::new('salary')
                ->setLabel('Salaire')
                ->hideOnIndex(),
            TextEditorField::new('schedule')
                ->setLabel('Emploi de temps')
                ->setFormType(CKEditorType::class)
                ->hideOnIndex(),
            AssociationField::new('users')
                ->setLabel('Candidats'),
            AssociationField::new('users')
               ->setLabel('Recruteur'),
            BooleanField::new('isApproved')
                ->setLabel('Approuvé ?'),
            BooleanField::new('isPublished')
                ->setLabel('Publié ?')
        ];
    }
}
