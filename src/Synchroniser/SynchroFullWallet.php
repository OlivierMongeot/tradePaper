<?php

namespace App\Synchroniser;

use App\Entity\Token;
use App\Entity\Users;
use App\Entity\Wallets;
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
        //get All users wallets
        $usersRepo = $this->entityManager->getRepository(Users::class);
        $users = $usersRepo->findAll();
        // foreach user update the wallet with the tokens
        // dump($users);

        foreach ($users as $user) {
            // dump($user);
            $allTradesByUser = $user->getTrades();
        
            $tradesByToken = [];
         

            if (!null == $allTradesByUser) {
                // Regroupe les trades par token et action 
                foreach ($allTradesByUser as $trade) {

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


                // Calcul les ajout de token des trades  action
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
                            // TODO : calcul des fee en token et soustract le montant du montant de la transaction
                        }
                    }
        

                    // Set the token quantity in the wallet
                    $wallet = $user->getWallets()->filter(function ($wallet) use ($token) {
                        return $wallet->getToken()->getName() == $token;
                    })->first();
                  
                    if(!null == $wallet){
                        $wallet->setQuantity($tokenQuantity);
                        $this->entityManager->persist($wallet);
                        $this->entityManager->flush();
                        
                    } else {
                        $wallet = new Wallets();
                        $tokenRepo = $this->entityManager->getRepository(Token::class);
                        $token = $tokenRepo->findOneBy(['name' => $token]);
                        $wallet->setToken($token);
                        $wallet->setQuantity($tokenQuantity);
                        $wallet->setUser($user);
                        $this->entityManager->persist($wallet);
                        $this->entityManager->flush();
                    }
                    
                }
            }
        }

    }

    public function synchroniseByUser(Users $user){
        $trades = $user->getTrades();
        $tradesByToken = [];
        foreach ($trades as $trade) {
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
                    // TODO : calcul des fee en token et soustract le montant du montant de la transaction
                }
            }
            $wallet = $user->getWallets()->filter(function ($wallet) use ($token) {
                return $wallet->getToken()->getName() == $token;
            })->first();
            if(!null == $wallet){
                $wallet->setQuantity($tokenQuantity);
                $this->entityManager->persist($wallet);
                $this->entityManager->flush();
                
            } else {
                $wallet = new Wallets();
                $tokenRepo = $this->entityManager->getRepository(Token::class);
                $token = $tokenRepo->findOneBy(['name' => $token]);
                $wallet->setToken($token);
                $wallet->setQuantity($tokenQuantity);
                $wallet->setUser($user);
                $this->entityManager->persist($wallet);
                $this->entityManager->flush();
            }
            
        }

    }
}
