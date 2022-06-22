<?php

namespace App\Controller\Admin;


use App\Entity\Trade;
use App\Entity\TotalTrade;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
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
            // set read only field to ID field
            IdField::new('id')->setFormTypeOption('disabled','disabled')->setColumns('col-3'),
            DateField::new('created_at')->setFormat('d/M/Y')->setLabel('Date')->setColumns('col-sm-4 col-lg-2 col-xxl-2'),
            AssociationField::new('action')
                ->setLabel('Action')->setColumns('col-sm-6 col-lg-3 col-xxl-3'),
            NumberField::new('quantity')->setLabel('Quantity')->setColumns('col-sm-6 col-lg-4 col-xxl-4')->setNumDecimals(7),
            AssociationField::new('token')
                ->setLabel('Token')->setColumns('col-sm-6 col-lg-3 col-xxl-3'),
            MoneyField::new('token_price_transaction')->setCurrency('USD')->setLabel('Token Price')->setColumns('col-sm-6 col-lg-3 col-xxl-3')->setNumDecimals(5),
            MoneyField::new('fee')->setCurrency('USD')->setColumns('col-sm-6 col-lg-3 col-xxl-3')->setNumDecimals(3)->hideOnIndex(),
            AssociationField::new('exchange')->setColumns('col-sm-6 col-lg-3 col-xxl-3'),
            NumberField::new('IdBuyTransaction')->setColumns('col-sm-6 col-lg-6 col-xxl-6')->setLabel('Id BUY'),
            MoneyField::new('order_mount')->setCurrency('USD')->setColumns('col-sm-6 col-lg-6 col-xxl-6')->setNumDecimals(3),
            TextEditorField::new('note')->setColumns('col-sm-6 col-lg-6 col-xxl-6')->hideOnIndex(),
        ];
    }


    public function persistEntity(EntityManagerInterface  $entity, $entityInstance): void
    {
        if (!$entityInstance instanceof Trade) {
            return;
        }
        if ($entityInstance instanceof Trade) {
            $entityInstance->setUser($this->getUser());
     
            $entityInstance->setOrderMount($entityInstance->getTokenPriceTransaction() * $entityInstance->getQuantity() + $entityInstance->getFee());
        }
        parent::persistEntity($entity, $entityInstance);

    }

    public function updateEntity(EntityManagerInterface $entity, $entityInstance): void
    {
        if ($entityInstance instanceof Trade) {

            $entityInstance->setOrderMount($entityInstance->getTokenPriceTransaction() * $entityInstance->getQuantity() + $entityInstance->getFee());
        }
        parent::persistEntity($entity, $entityInstance);

    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('token')
            ->add('action')
            ->add('exchange')
            ->add('created_at')
            ->add('user');
    }

}
