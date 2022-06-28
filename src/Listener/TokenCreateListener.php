<?php

namespace App\Listener;

use App\Entity\Token;
use App\Entity\Wallet;
use Doctrine\Persistence\Event\LifecycleEventArgs;


class TokenCreateListener
{
    public function postPersist(LifecycleEventArgs $event)
    {
        $this->updateToken($event);
    }


    public function postUpdate(LifecycleEventArgs $event)
    {
        //  dd($event);
        $this->updateToken($event);
    }

    private function updateToken(LifecycleEventArgs $event)
    {

        $entity = $event->getObject();

        if ($entity instanceof Token) {
            // dump($entity->getName());
            // Update token  name in wallet
            // $entityManager = $event->getObjectManager();
            // $wallet = $entityManager->getRepository(Wallet::class)->findOneBy(['token' => $entity->getName()]);
            // dd($wallet);
            // $wallet->setToken($entity->getName());
            // $entityManager->persist($wallet);
            // $entityManager->flush();
        }
    }

    public function preUpdate(LifecycleEventArgs $event)
    {
        $entity = $event->getObject();
        if ($entity instanceof Token) {
            // dump($event);
            // $entity = $event->getObjectManager();
            // dd($entity);:
        // Get old name of token
        // $token
        }


        // $this->updateToken($event);
    }
}
