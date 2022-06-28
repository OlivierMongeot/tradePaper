<?php

namespace App\Controller;


use App\Entity\Token;
use App\Entity\Wallets;
use App\Api\LivePriceApi;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_main")
     */
    public function index(EntityManagerInterface $em): Response
    {
        // Check if user is connected and registerd
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        // Display Wallet with quantity of tokens and price live of each token
        $entityManager = $this->getDoctrine()->getManager();

        $tokens = $entityManager->getRepository(Token::class)->findAll();
        $tokensLinksArray = array();
        foreach ($tokens as $token) {
            $tokensLinksArray[$token->getName()] = $token->getFile();
            $tokensForAPI[] = $token->getName();
        }

        $user = $this->getUser();
        $api = new LivePriceApi($em, $user);
        $prices = $api->getPrices($tokensForAPI);
        // dd($prices);
        $k = 0;
        $message = null;
        $totalWalletValue = 0;
        $tokensArray = array();
        $WaletsEntities = $entityManager->getRepository(Wallets::class)->findBy(['user' => $user]);
        // dump($prices->data);
        // dump($WaletsEntities);
        // Merge array with tokens, quantity and price live
        if (isset($prices->data)) {
            foreach ($WaletsEntities as $wallet) {
                // dump($wallet);
                $tokensArray[$k]['token'] = $wallet->getToken()->getName();
                $tokensArray[$k]['quantity'] = $wallet->getQuantity();
                $tokenName = $wallet->getToken()->getName();
                $tokensArray[$k]['livePrice'] = $prices->data->$tokenName->quote->USD->price;
                $tokensArray[$k]['variation_1h'] = $prices->data->$tokenName->quote->USD->percent_change_1h;
                $tokensArray[$k]['variation_24h'] = $prices->data->$tokenName->quote->USD->percent_change_24h;
                $tokensArray[$k]['variation_7d'] = $prices->data->$tokenName->quote->USD->percent_change_7d;
                $tokensArray[$k]['variation_60d'] = $prices->data->$tokenName->quote->USD->percent_change_60d;
                $tokensArray[$k]['value'] = $prices->data->$tokenName->quote->USD->price * $wallet->getQuantity();
                $k++;
                $totalWalletValue += $prices->data->$tokenName->quote->USD->price * $wallet->getQuantity();
            }
        } else {
            $message = 'No prices found with API';
        }
        // dump($tokensArray);
        // dd($totalWalletValue);
        // dd($tokensArray);
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'tokensArray' => $tokensArray,
            'totalWalletValue' => $totalWalletValue,
            'tokensLinksArray' => $tokensLinksArray,
            'message' => $message,
        ]);
     
    }
}
// +"ALGO": {#1167 ▼
//     +"id": 4030
//     +"name": "Algorand"
//     +"symbol": "ALGO"
//     +"slug": "algorand"
//     +"num_market_pairs": 227
//     +"date_added": "2019-06-20T00:00:00.000Z"
//     +"tags": array:9 [▶]
//     +"max_supply": 10000000000
//     +"circulating_supply": 6899230244.9403
//     +"total_supply": 7293069191.7503
//     +"is_active": 1
//     +"platform": null
//     +"cmc_rank": 27
//     +"is_fiat": 0
//     +"self_reported_circulating_supply": null
//     +"self_reported_market_cap": null
//     +"tvl_ratio": null
//     +"last_updated": "2022-06-27T16:23:00.000Z"
//     +"quote": {#1169 ▼
//       +"USD": {#1168 ▼
//         +"price": 0.33044088885941
//         +"volume_24h": 70867659.3384
//         +"volume_change_24h": -7.4856
//         +"percent_change_1h": 0.04573276
//         +"percent_change_24h": -3.79634123
//         +"percent_change_7d": 3.82729392
//         +"percent_change_30d": -10.2743478
//         +"percent_change_60d": -50.93296532
//         +"percent_change_90d": -63.9585505
//         +"market_cap": 2279787774.5838
//         +"market_cap_dominance": 0.2445
//         +"fully_diluted_market_cap": 3304408888.59
//         +"tvl": null
//         +"last_updated": "2022-06-27T16:23:00.000Z"
//       }
//     }
//   }