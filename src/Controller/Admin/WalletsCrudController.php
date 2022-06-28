<?php

namespace App\Controller\Admin;

use App\Entity\Wallets;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class WalletsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Wallets::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
           
            AssociationField::new('user')->setLabel('User'),
            AssociationField::new('token')->setLabel('Token'),
            NumberField::new('quantity')->setLabel('Quantity'),
        ];
    }    
}
