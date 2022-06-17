<?php

namespace App\Controller\Admin;


use App\Entity\Trade;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;

use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Doctrine\ORM\EntityManagerInterface;

class TradeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Trade::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            // IdField::new('id')
            DateField::new('created_at')->setFormat('d/m/Y')->setLabel('Date')->setColumns('col-sm-6 col-lg-3 col-xxl-3'),
            AssociationField::new('action')
                ->setLabel('Action')->setColumns('col-sm-6 col-lg-3 col-xxl-3'),
                // set precision to 10  and scale to 2
                // set number_format to true to display the number with 5 decimals
            // NumberField::new('qty')->setLabel('Quantity')->setColumns('col-sm-6 col-lg-3 col-xxl-3')->setNumberFormat(true, 10, 2),
            NumberField::new('qty')->setLabel('Quantity')->setColumns('col-sm-6 col-lg-3 col-xxl-3')->setNumDecimals(7),
            AssociationField::new('token')
                ->setLabel('Token')->setColumns('col-sm-6 col-lg-3 col-xxl-3'),
            
            MoneyField::new('token_price_transaction')->setCurrency('USD')->setLabel('Token Price')->setColumns('col-sm-6 col-lg-3 col-xxl-3')->setNumDecimals(3),
            
            MoneyField::new('fee')->setCurrency('USD')->setColumns('col-sm-6 col-lg-3 col-xxl-3')->setNumDecimals(3),
            // Hide and auto set user id
           
            AssociationField::new('exchange'),
            TextEditorField::new('note')->setColumns('col-sm-6 col-lg-6 col-xxl-6'),
            MoneyField::new('order_mount')->setCurrency('USD')->setColumns('col-sm-6 col-lg-6 col-xxl-6')->setNumDecimals(3),
            // AssociationField::new('user'),
        ];
    }

 
    public function persistEntity(EntityManagerInterface  $entity, $entityInstance):void
    {
        if (!$entityInstance instanceof Trade) {
            return;
        }
        if ($entityInstance instanceof Trade) {
            $entityInstance->setUser($this->getUser());
            // set order_mount
            $entityInstance->setOrderMount($entityInstance->getTokenPriceTransaction() * $entityInstance->getQty() + $entityInstance->getFee());
            $entityInstance->setQuantity($entityInstance->getQty());
        }
          parent::persistEntity($entity, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entity, $entityInstance): void
    {
        if ($entityInstance instanceof Trade) {
           
            $entityInstance->setOrderMount($entityInstance->getTokenPriceTransaction() * $entityInstance->getQty() + $entityInstance->getFee());

        }
          parent::persistEntity($entity, $entityInstance);
    }
  
    
}
