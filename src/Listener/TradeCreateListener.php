<?php

namespace App\Listener;

use App\Entity\Trade;
use App\Entity\Wallets;
use App\MoveRegister\MoveRegister;
use App\Synchroniser\SynchroFullWallet;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\Event\LifecycleEventArgs;


class TradeCreateListener
{
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function postPersist(LifecycleEventArgs $event)
    {
        $this->persistWallet($event);
    }


    public function postUpdate(LifecycleEventArgs $event)
    {
        $entity = $event->getObject();
        // $this->postUpdateWallet($event);
        if ($entity instanceof Trade) {
            $synchro = new SynchroFullWallet($this->em);
            // $synchro->synchronise();
            $trade = $event->getObject();
            dd($trade);
            // dd($trade->getUser());
            $user = $trade->getUser();
            $synchro->synchroniseByUser($user);
        }
    }


    public function preUpdate(LifecycleEventArgs $event)
    {
    }


    private function persistWallet(LifecycleEventArgs $event)
    {
        $message = new MoveRegister();
        $message->recordInfo('TradeCreateListener::persistWallet');
        $entity = $event->getObject();
        if ($entity instanceof Trade) {
            // dd($entity);

            $message->recordInfo('Trade created->update or create Wallet');

            $entityManager = $event->getObjectManager();

            // Get user 
            $user = $entity->getUser();
            // Get wallet user 
            $walletUserToken = $user->getWallets()->filter(function (Wallets $wallet) use ($entity) {
                return $wallet->getToken()->getId() == $entity->getToken()->getId();
            })->first();
            // dd($walletUser);
            // Get current token

            $message->recordInfo('User: ' . $user->getUsername() . ' Token: ' . $entity->getToken()->getName());
            // dump($walletUser);

            // Check if token ever exist in wallet user
            if ($walletUserToken == !null) {
                // if exist update quantity
                // Make addition for action Achat, Earn, Interet
                if ($entity->getAction()->getId() == 1 || $entity->getAction()->getId() == 6) {
                    $walletUserToken->setQuantity($walletUserToken->getQuantity() + $entity->getQuantity());
                } else if ($entity->getAction()->getId() == 2) {
                    // Make substraction for action Vente
                    $walletUserToken->setQuantity($walletUserToken->getQuantity() - $entity->getQuantity());
                } else if ($entity->getAction()->getId() == 3) {
                    // Make substraction for action Interet
                    $walletUserToken->setQuantity($walletUserToken->getQuantity() - $entity->getQuantity());
                } else if ($entity->getAction()->getId() == 4) {
                    // Make substraction for action Swap
                    $walletUserToken->setQuantity($walletUserToken->getQuantity() - $entity->getQuantity());
                } else if ($entity->getAction()->getId() == 5) {
                    // Make substraction for action Transfer
                    $walletUserToken->setQuantity($walletUserToken->getQuantity() - $entity->getQuantity());
                }
                // Update wallet user
                $entityManager->persist($walletUserToken);
                //flush
                $entityManager->flush();
                $message->recordInfo('Wallet updated');
            } else {
                // if not exist create new wallet
                $walletUserToken = new Wallets();
                $walletUserToken->setUser($user);
                $walletUserToken->setToken($entity->getToken());
                // Make addition for action Achat, Earn, Interet and soustraction for action Vente
                if ($entity->getAction()->getId() == 1 || $entity->getAction()->getId() == 6) {
                    $walletUserToken->setQuantity($entity->getQuantity());
                } else if ($entity->getAction()->getId() == 2) {
                    $walletUserToken->setQuantity($entity->getQuantity() * -1);
                } else if ($entity->getAction()->getId() == 3) {
                    $walletUserToken->setQuantity($entity->getQuantity() * -1);
                } else if ($entity->getAction()->getId() == 4) {
                    $walletUserToken->setQuantity($entity->getQuantity() * -1);
                } else if ($entity->getAction()->getId() == 5) {
                    $walletUserToken->setQuantity($entity->getQuantity() * -1);
                }

                $entityManager->persist($walletUserToken);
                $entityManager->flush();

                $message->recordInfo('Wallet created');
            }
        }
    }
}
