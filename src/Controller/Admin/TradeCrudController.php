<?php

namespace App\Controller\Admin;

use App\Entity\Token;
use App\Entity\Trade;
use App\Entity\Action;
use App\Entity\Exchange;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TradeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Trade::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            // IdField::new('id'),
            DateField::new('created_at')->setFormat('d/m/Y')->setLabel('Date'),
            AssociationField::new('action')
                ->setLabel('Action'),
            AssociationField::new('token')
                ->setLabel('Token'),
            MoneyField::new('token_price_transaction')->setCurrency('USD')->setLabel('Token Price'),
            NumberField::new('quantity'),
            MoneyField::new('fee')->setCurrency('USD'),
            // Hide and auto set user id
            AssociationField::new('user'),
            AssociationField::new('exchange'),
         
        ];
    }
    
}
