<?php

namespace App\Controller\Admin;


use App\Entity\Trade;
use App\Entity\TotalTrade;
use Doctrine\ORM\EntityManagerInterface;
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
            // IdField::new('id')
            DateField::new('created_at')->setFormat('d/m/Y')->setLabel('Date')->setColumns('col-sm-6 col-lg-3 col-xxl-3'),
            AssociationField::new('action')
                ->setLabel('Action')->setColumns('col-sm-6 col-lg-3 col-xxl-3'),
            // set precision to 10  and scale to 2
            // set number_format to true to display the number with 5 decimals
            // NumberField::new('qty')->setLabel('Quantity')->setColumns('col-sm-6 col-lg-3 col-xxl-3')->setNumberFormat(true, 10, 2),
            NumberField::new('quantity')->setLabel('Quantity')->setColumns('col-sm-6 col-lg-3 col-xxl-3')->setNumDecimals(7),
            AssociationField::new('token')
                ->setLabel('Token')->setColumns('col-sm-6 col-lg-3 col-xxl-3'),

            MoneyField::new('token_price_transaction')->setCurrency('USD')->setLabel('Token Price')->setColumns('col-sm-6 col-lg-3 col-xxl-3')->setNumDecimals(3),

            MoneyField::new('fee')->setCurrency('USD')->setColumns('col-sm-6 col-lg-3 col-xxl-3')->setNumDecimals(3)->hideOnIndex(),
            // Hide and auto set user id

            AssociationField::new('exchange'),
            TextEditorField::new('note')->setColumns('col-sm-6 col-lg-6 col-xxl-6')->hideOnIndex(),
            MoneyField::new('order_mount')->setCurrency('USD')->setColumns('col-sm-6 col-lg-6 col-xxl-6')->setNumDecimals(3),
            // AssociationField::new('user'),
        ];
    }


    public function persistEntity(EntityManagerInterface  $entity, $entityInstance): void
    {
        if (!$entityInstance instanceof Trade) {
            return;
        }
        if ($entityInstance instanceof Trade) {
            $entityInstance->setUser($this->getUser());
            // set order_mount
            $entityInstance->setOrderMount($entityInstance->getTokenPriceTransaction() * $entityInstance->getQuantity() + $entityInstance->getFee());
            // $entityInstance->setQuantity($entityInstance->getQuantity());

        }
        parent::persistEntity($entity, $entityInstance);
        // Update the total of sell, buy and balance in TotalTrade Entity
         // Calcul the total of sell, buy and balance in TotalTrade Entity
    //     $totalTrade = $entity->getRepository(TotalTrade::class)->findOneBy(['token' => $entityInstance->getToken()]);
    //     dd($totalTrade);

    //     if ($entityInstance instanceof Trade) {
    //         if ($entityInstance->getAction()->getId() == 1) {
    //             $totalTrade->setTotalSell($totalTrade->getTotalSell() + $entityInstance->getOrderMount());
    //         } else {
    //             $totalTrade->setTotalBuy($totalTrade->getTotalBuy() + $entityInstance->getOrderMount());
    //         }
    //         $totalTrade->setTotalBalance($totalTrade->getTotalSell() - $totalTrade->getTotalBuy());
    //     }
    //     $entity->persist($totalTrade);
    //     $entity->flush();
    //    // Creart new instance of TotalTrade
    //     $totalTrade = new TotalTrade();
         
        // $totalTrade->getSumOfSelltrade($entityInstance->getAction()->getToken());
    }

    public function updateEntity(EntityManagerInterface $entity, $entityInstance): void
    {
        if ($entityInstance instanceof Trade) {

            $entityInstance->setOrderMount($entityInstance->getTokenPriceTransaction() * $entityInstance->getQuantity() + $entityInstance->getFee());
        }
        parent::persistEntity($entity, $entityInstance);

        // Update the total of sell, buy and balance in TotalTrade Entity
         // Calcul the total of sell, buy and balance in TotalTrade Entity
        //  $repoTotalTrade = $entity->getRepository(TotalTrade::class);
        //  $repoTrade = $entity->getRepository(Trade::class);
        //  $totalTrade = $repoTotalTrade->findBy(['token' => $entityInstance->getToken()]);
       
        //  dd($totalTrade);
        //  if($totalTrade){
        //     // update the total of sell, buy and balance in TotalTrade Entity


        //  } 
        //  else {
        //     // create new instance of TotalTrade
        //     $totalTrade = new TotalTrade();
        //     $totalTrade->setToken($entityInstance->getToken());
        //     $sum = $repoTrade->getSumSell($entityInstance->getToken());
        //     $totalTrade->setSell($sum);
        //  }
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


    // public function updateTotalTrade($trade, EntityManagerInterface $entity)
    // {
    //     $totalTrade = $entity->getRepository(Trade::class)->findBy(['token' => $trade->getToken()]);
    //     // dd($totalTrade);
    //     $totalBuy = 0;
    //     $totalSell = 0;
    //     $totalBalance = 0;
    //     foreach ($totalTrade as $trade) {
    //         if ($trade->getAction() == 'buy') {
    //             $totalBuy += $trade->getOrderMount();
    //         } else {
    //             $totalSell += $trade->getOrderMount();
    //         }
    //     }
    //     $totalBalance = $totalBuy - $totalSell;
    //     $totalTrade = $entity->getRepository(TotalTrade::class)->findOneBy(['token' => $trade->getToken()]);
    //     if ($totalTrade) {
    //         $$this->setTotalBuy($totalBuy);
    //         $totalTrade->setTotalSell($totalSell);
    //         $totalTrade->setTotalBalance($totalBalance);
    //         $entity->persist($totalTrade);
    //         $entity->flush();
    //     } else {
    //         $totalTrade = new TotalTrade();
    //         $totalTrade->setToken($trade->getToken());
    //         $totalTrade->setTotalBuy($totalBuy);
    //         $totalTrade->setTotalSell($totalSell);
    //         $totalTrade->setTotalBalance($totalBalance);
    //         $entity->persist($totalTrade);
    //         $entity->flush();
    //     }
        
    // }
}
