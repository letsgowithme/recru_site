<?php

namespace App\Controller\Admin;

use App\Entity\Candidate;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\FileUploadType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class CandidateCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Candidate::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
    return $crud
                ->setEntityLabelInPlural('Candidats')
                ->setEntityLabelInSingular('Candidat')
                ->setPageTitle("index", "Administration des candidats")
                ->setDefaultSort(['candidate.lastname' => 'asc'])
                ->setPageTitle(pageName:Crud::PAGE_INDEX, title: 'Candidats')
                
    ;
    }
    public function configureFields(string $pageName): iterable
    {
         $roles = ['ROLE_CANDIDATE', 'ROLE_USER'];
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
    ->setBasePath('/uploads/cv')
    ->hideOnIndex()
    ->setRequired(false) 
    ->setLabel('CV')
    ->setRequired($pageName !== Crud::PAGE_EDIT),
    DateTimeField::new('createdAt')
    ->hideOnForm()
    ->setFormTypeOption('disabled', 'disabled'),
    ];
    }
}
