<?php

namespace App\Parser;

class TradeAgregator
{


    public function agregateData(array $allTrades): array
    {
        $tradesByToken = [];
        foreach ($allTrades as $trade) {
            // check if it's a sell or buy trade
            if ($trade->getAction()->getId() == 1) {
                $tradesByToken[$trade->getToken()->getName()]['sell'][] = $trade;
            } else  if ($trade->getAction()->getId() == 2){
                $tradesByToken[$trade->getToken()->getName()]['buy'][] = $trade;
            } else if ($trade->getAction()->getId() == 3) {
                $tradesByToken[$trade->getToken()->getName()]['interest'][] = $trade;
            }   else if ($trade->getAction()->getId() == 4) {
                $tradesByToken[$trade->getToken()->getName()]['swap'][] = $trade;
            }   else if ($trade->getAction()->getId() == 5) {
                $tradesByToken[$trade->getToken()->getName()]['transfer'][] = $trade;
            }   else if ($trade->getAction()->getId() == 6) {
                $tradesByToken[$trade->getToken()->getName()]['earn'][] = $trade;
            }
        }

        $fullSellTrades = 0;
        $fullBuyTrades = 0;
        $fullBalanceTrades = 0;
      

        //Add to the array the calcul total mount of trades for sell, buy and balance
        foreach ($tradesByToken as $token => $trade) {
            $totalSell = 0;
            $totalBuy = 0;
            $totalBalance = 0;
            $tokenQuantity = 0;
            // dd($trade);
            if (isset($trade['sell'])) {
                foreach ($trade['sell'] as $sell) {
                    $totalSell += $sell->getOrderMount();
                    $tokenQuantity -= $sell->getQuantity();
                }
            }
           
            if (isset($trade['buy'])) {
                foreach ($trade['buy'] as $buy) {
                    $totalBuy += $buy->getOrderMount();
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
            
            $totalBalance = $totalSell - $totalBuy;
         
            $tradesByToken[$token]['token'] = $token;
            $tradesByToken[$token]['totalSell'] = $totalSell;
            $tradesByToken[$token]['totalBuy'] = $totalBuy;
            $tradesByToken[$token]['totalBalance'] = $totalBalance;
            $tradesByToken[$token]['tokenQuantity'] = $tokenQuantity;

            if ($token != 'USDT') {
                $fullSellTrades += $totalSell;
                $fullBuyTrades += $totalBuy;
                $fullBalanceTrades += $totalBalance;
            }
         
        }

        $totalTrades['fullSellTrades'] = $fullSellTrades;
        $totalTrades['fullBuyTrades'] = $fullBuyTrades;
        $totalTrades['fullBalanceTrades'] = $fullBalanceTrades;
        
        return [$tradesByToken, $totalTrades];
    }


}