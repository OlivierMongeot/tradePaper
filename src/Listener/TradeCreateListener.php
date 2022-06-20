<?php

namespace App\Listener;

use App\Entity\Trade;
use App\Entity\TotalTrade;
use Doctrine\Persistence\Event\LifecycleEventArgs;


class TradeCreateListener
{
    public function postPersist(LifecycleEventArgs $event)
    {
      $this->updateTotalTrade($event);
    }


    public function postUpdate(LifecycleEventArgs $event)
    {
        //  dd($event);
      $this->updateTotalTrade($event);
    }


    private function updateTotalTrade(LifecycleEventArgs $event){


        $entity = $event->getObject();
        if ($entity instanceof Trade) {
            $entityManager = $event->getObjectManager();
          
            $totalTrade = $entityManager->getRepository(Trade::class)->findBy(
                [
                    'token' => $entity->getToken(),
                ]
            );
            $totalSell = 0;
            $totalBuy = 0;
            $totalEarn = 0;
            $balance = 0;
            
            foreach ($totalTrade as $trade) {
                // dump($trade->getAction()->getId());
                // ID 1 Vente /ID 2 Achat/ ID 3 Interet 
                if ($trade->getAction()->getId() == 1) {
                    $totalSell += $trade->getOrderMount();
                } else  if ($trade->getAction()->getId() == 2) {
                    $totalBuy += $trade->getOrderMount();
                } else if ($trade->getAction()->getId() == 3) {
                    $totalEarn += $trade->getOrderMount();
                }
            }

            $balance = $totalSell + $totalEarn - $totalBuy;
           
            // inject total of trade mount for this token in TotalTrade entity
            $totalTrade = $entityManager->getRepository(TotalTrade::class)->findOneBy(
                [
                    'token' => $entity->getToken()->getName(),
                ]
            );
            // dump($entity->getToken()->getName());
            // // dump($totalTrade);
            // dd($totalTrade);
            if ($totalTrade != null) {
                $totalTrade->setSell($totalSell);
                $totalTrade->setBuy($totalBuy + $totalEarn);
                $totalTrade->setBalance($balance);
                $entityManager->persist($totalTrade);
                $entityManager->flush();
            } else {
                $totalTrade = new TotalTrade();
                $totalTrade->setToken($entity->getToken());
                $totalTrade->setSell($totalSell);
                $totalTrade->setBuy($totalBuy + $totalEarn);
                $totalTrade->setBalance($balance);
                $entityManager->persist($totalTrade);
                $entityManager->flush();
            }
        }

    }

}
