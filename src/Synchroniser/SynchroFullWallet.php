<?php

namespace App\Synchroniser;

use App\Entity\Trade;
use App\Entity\Wallet;
use Doctrine\ORM\EntityManagerInterface;

class SynchroFullWallet
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function synchronise()
    {

        $allTrades = $this->entityManager->getRepository(Trade::class)->findAll();
        $tradesByToken = [];

        foreach ($allTrades as $trade) {

            if ($trade->getAction()->getId() == 1) {
                $tradesByToken[$trade->getToken()->getName()]['sell'][] = $trade;
            } else  if ($trade->getAction()->getId() == 2) {
                $tradesByToken[$trade->getToken()->getName()]['buy'][] = $trade;
            } else if ($trade->getAction()->getId() == 3) {
                $tradesByToken[$trade->getToken()->getName()]['interest'][] = $trade;
            } else if ($trade->getAction()->getId() == 4) {
                $tradesByToken[$trade->getToken()->getName()]['swap'][] = $trade;
            } else if ($trade->getAction()->getId() == 5) {
                $tradesByToken[$trade->getToken()->getName()]['transfer'][] = $trade;
            } else if ($trade->getAction()->getId() == 6) {
                $tradesByToken[$trade->getToken()->getName()]['earn'][] = $trade;
            }
        }
        // Get current wallet repository
        $walletRepo = $this->entityManager->getRepository(Wallet::class);
     
        foreach ($tradesByToken as $token => $trade) {
          
            $tokenQuantity = 0;

            if (isset($trade['sell'])) {
                foreach ($trade['sell'] as $sell) {
                    $tokenQuantity -= $sell->getQuantity();
                }
            }

            if (isset($trade['buy'])) {
                foreach ($trade['buy'] as $buy) {
                    $tokenQuantity += $buy->getQuantity();
                }
            }

            if (isset($trade['interest'])) {
                foreach ($trade['interest'] as $interest) {
                    $tokenQuantity += $interest->getQuantity();
                }
            }

            if (isset($trade['earn'])) {
                foreach ($trade['earn'] as $earn) {
                    $tokenQuantity += $earn->getQuantity();
                }
            }

            if (isset($trade['transfer'])) {
                foreach ($trade['transfer'] as $transfer) {
                    // $tokenQuantity -= $transfer->getQuantity();
                    // calcul des fee en token et soustract le montant du montant de la transaction
                }
            }
            // Set the token quantity in the wallet
            // check if the token exist in the wallet
            $walletToken = $walletRepo->findOneBy(['token' => $token]);
            if ($walletToken) {
                $walletToken->setQuantity($tokenQuantity);
                $this->entityManager->persist($walletToken);
                $this->entityManager->flush();
            } else {
                $walletToken = new Wallet();
                $walletToken->setToken($token);
                $walletToken->setQuantity($tokenQuantity);
                $this->entityManager->persist($walletToken);
                $this->entityManager->flush();
            }
        }




   
    
    }
}
