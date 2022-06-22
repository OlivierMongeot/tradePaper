<?php

namespace App\Controller\Admin;

use App\Entity\Configuration;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ConfigurationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Configuration::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->setFormTypeOption('disabled','disabled')->setColumns('col-3'),
            DateField::new('start_date')->setFormat('d/M/Y')->setColumns('col-sm-4 col-lg-2 col-xxl-2')->setLabel('Start Date'),
            DateField::new('end_date')->setFormat('d/M/Y')->setLabel('End Date')->setColumns('col-sm-4 col-lg-2 col-xxl-2'),
            AssociationField::new('token')
                ->setLabel('Token')->setColumns('col-sm-6 col-lg-3 col-xxl-3'),
            AssociationField::new('exchange')->setColumns('col-sm-6 col-lg-3 col-xxl-3')

        ];
    }
    
}
