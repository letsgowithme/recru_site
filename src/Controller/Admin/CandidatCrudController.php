<?php

namespace App\Controller\Admin;

use App\Entity\Candidat;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\FileUploadType;

class CandidatCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Candidat::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
    return $crud
                ->setEntityLabelInPlural('Candidats')
                ->setEntityLabelInSingular('Candidat')
                // ->setSearchFields(['lastname'])
                ->setPageTitle("index", "Administration des candidats")
                // ->setDefaultSort(['lastname' => 'asc'])
                ->setPageTitle(pageName:Crud::PAGE_INDEX, title: 'Candidats')
                
    ;
    }
    public function configureFields(string $pageName): iterable
    {
         $roles = ['ROLE_CANDIDAT', 'ROLE_USER'];
    return [
    IdField::new('id')
    ->hideOnForm(),
    // TextField::new('lastname')
    // ->setLabel('Nom'),
    // TextField::new('firstname')
    // ->setLabel('Prénom'),
    // TextField::new('email'),
    AssociationField::new('jobs')
    ->setLabel('Offres d\'emploi'),
    ImageField::new('cvFilename')
    ->setFormType(FileUploadType::class)
    ->setUploadDir('/public/uploads/cv')
    ->setRequired(false)
    ->hideOnForm() 
    ->setLabel('CV'),
    DateTimeField::new('createdAt')
    ->hideOnForm()
    ->setFormTypeOption('disabled', 'disabled'),
    // BooleanField::new('isVerified')
    //             ->setLabel('Approuvé ?')
    ];
    }
}