<?php

namespace App\Listener;

use App\Entity\Trade;
use App\Entity\Wallet;
use App\MoveRegister\MoveRegister;
use Doctrine\Persistence\Event\LifecycleEventArgs;


class TradeCreateListener
{
    public function postPersist(LifecycleEventArgs $event)
    {
      $this->persistWallet($event);
    }


    public function postUpdate(LifecycleEventArgs $event)
    {
        //  dd($event);
    //   $this->updateWallet($event);
    }


    public function preUpdate(LifecycleEventArgs $event)
    {
        //  dd($event);
      $this->updateWallet($event);
    }


    private function persistWallet(LifecycleEventArgs $event){


        $entity = $event->getObject();
        if ($entity instanceof Trade) {
            // dd($entity);
            $message = new MoveRegister();
            $message->recordInfo('Trade created');
            
            $entityManager = $event->getObjectManager();
        
            $walletEntity = $entityManager->getRepository(Wallet::class)->findOneBy(['token' => $entity->getToken()->getName()]);
            $message->recordInfo('Last wallet quantity: ' . $walletEntity->getQuantity());
            if ($walletEntity) {
                $message->recordInfo('Update Wallet -> action: ' . $entity->getAction());
                if($entity->getAction() == 'Achat' || $entity->getAction() == 'Earn' || $entity->getAction() == 'Intérêt'){
                    $walletEntity->setQuantity($walletEntity->getQuantity() + $entity->getQuantity());
                } else if($entity->getAction() == 'Vente'){
                    $walletEntity->setQuantity($walletEntity->getQuantity() - $entity->getQuantity());
                } else if($entity->getAction() == 'Transfert'){
                    $walletEntity->setQuantity($walletEntity->getQuantity());
                }
                $entityManager->persist($walletEntity);
                $entityManager->flush();
            } else {
                $message->recordInfo('Wallet not found');
                $message->recordInfo('Create Wallet -> action: ' . $entity->getAction());
                $walletEntity = new Wallet();
                $walletEntity->setToken($entity->getToken()->getName());
                if($entity->getAction() == 'Achat' || $entity->getAction() == 'Earn' || $entity->getAction() == 'Intérêt'){
                    $walletEntity->setQuantity($entity->getQuantity());
                } else if($entity->getAction() == 'Vente'){
                    $walletEntity->setQuantity($entity->getQuantity() * -1);
                } else if($entity->getAction() == 'Transfert'){
                    $walletEntity->setQuantity($entity->getQuantity());
                }
                $entityManager->persist($walletEntity);
                $entityManager->flush();
            }   
            $message->recordInfo('New quantity: ' . $walletEntity->getQuantity() . ' ' . $walletEntity->getToken());
        }

    }


    private function updateWallet(LifecycleEventArgs $event){
        $entity = $event->getObject();
            if ($entity instanceof Trade) {
                $message = new MoveRegister();
                $message->recordInfo('Trade updated');
                $entityManager = $event->getObjectManager();
                $walletEntity = $entityManager->getRepository(Wallet::class)->findOneBy(['token' => $entity->getToken()->getName()]);
                if ($walletEntity) {
                    $getCurrentQuantityWallet = $walletEntity->getQuantity();
                    // Get old Value of Quantity for this trade (before update)
                    $oldEntity = $entityManager->getRepository(Trade::class)->findOneBy(['id' => $entity->getId()]);
                    $oldQuantityTrade = $oldEntity->getQuantity();
                    $getUpdatedQuantityTrade = $entity->getQuantity();
                    $difference =  $getUpdatedQuantityTrade - $oldQuantityTrade;
                    $walletEntity->setQuantity($walletEntity->getQuantity() + $difference);
                    $entityManager->persist($walletEntity);
                    $entityManager->flush();
                    $message->recordInfo( 'Token:'. $entity->getToken()->getName() .' | Before action quantity Wallet: ' . $getCurrentQuantityWallet . '| Updated quantity: ' . $getUpdatedQuantityTrade . '| Difference: ' . $difference );
                } else {
                //  Lance un mmessage d'erreur
                throw new \Exception('Wallet not found');
                }
            }
    }

}
