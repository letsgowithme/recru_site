<?php

namespace App\Controller\Admin;

use App\Entity\Recruiter;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class RecruiterCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Recruiter::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
    return $crud
                ->setEntityLabelInPlural('Recruteurs')
                ->setEntityLabelInSingular('Recruteur')
                // ->setSearchFields(['user_id'])
                ->setPageTitle("index", "Administration des Recruteurs")
                // ->setDefaultSort(['user_id' => 'asc'])
                ->setPageTitle(pageName:Crud::PAGE_INDEX, title: 'Recruteurs')
                
    ;
    }
    public function configureFields(string $pageName): iterable
    {
         $roles = ['ROLE_RECRUITER', 'ROLE_USER'];
    return [
    IdField::new('id')
    ->hideOnForm(),
    // TextField::new('email'),
    AssociationField::new('company')
    ->setLabel('Company'),
    DateTimeField::new('createdAt')
    ->hideOnForm()
    ->setFormTypeOption('disabled', 'disabled'),
    BooleanField::new('isVerified')
                ->setLabel('Approuvé ?')
    ];
    }
}
