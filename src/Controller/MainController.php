<?php

namespace App\Controller;


use App\Entity\Token;
use App\Entity\Wallet;
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
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        // Check if user is connected and registerd
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        // Display Wallet with quantity of tokens and price live of each token
        $entityManager = $this->getDoctrine()->getManager();
        $tokens = $entityManager->getRepository(Wallet::class)->findAll();
        // Make simple array with tokens and quantity of tokens
        $tokensArray = array();
        $tokensForAPI = array();
        foreach ($tokens as $token) {

            $tokensForAPI[] = $token->getToken();
        }

        $tokensLinks = $entityManager->getRepository(Token::class)->findAll();
        $tokensLinksArray = array();
        foreach ($tokensLinks as $tokenLink) {
            $tokensLinksArray[$tokenLink->getName()] = $tokenLink->getFile();
        }
        // dd($tokensLinksArray);

        // Make request to API to get price of each token
        $user = $this->getUser();
        $api = new LivePriceApi($em, $user);
        $prices = $api->getPrices($tokensForAPI);
        // dd($prices->data);
        $k = 0;
        $totalWalletValue = 0;
        // Merge array with tokens, quantity and price live
        foreach ($tokens as $token) {
            $tokensArray[$k]['token'] = $token->getToken();
            $tokensArray[$k]['quantity'] = $token->getQuantity();
            $tokenName = $token->getToken();
            $tokensArray[$k]['livePrice'] = $prices->data->$tokenName->quote->USD->price;
            $tokensArray[$k]['value'] = $prices->data->$tokenName->quote->USD->price * $token->getQuantity();
            $k++;
            $totalWalletValue += $prices->data->$tokenName->quote->USD->price * $token->getQuantity();
        }
        // dd($tokensArray);


        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'tokensArray' => $tokensArray,
            'totalWalletValue' => $totalWalletValue,
            'tokensLinksArray' => $tokensLinksArray,
        ]);
    }
}
