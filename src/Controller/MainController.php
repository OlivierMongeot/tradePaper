<?php

namespace App\Controller;

use App\Entity\Token;
use App\Entity\Trade;
use App\Form\TradeType;
use App\Entity\Exchange;
use App\Entity\TotalTrade;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_main")
     */
    public function index(Request $request): Response
    {
        $trade = new Trade();
        $form = $this->createForm(TradeType::class, $trade);
        $form->handleRequest($request);
        $entityManager = $this->getDoctrine()->getManager();
        $trade = $entityManager->getRepository(Trade::class)->findAll();
        // inject Token and entities to form
        $token = $entityManager->getRepository(Token::class)->findAll();
        $totalTrade = $entityManager->getRepository(TotalTrade::class)->findAll();
        // Make assoc array with token , sell and buy
        $totalTokensTrades = [];
        foreach ($totalTrade as $trade) {
            // dump($trade);
            $totalTokensTrades[$trade->getToken()]['sell'] = $trade->getSell();
            $totalTokensTrades[$trade->getToken()]['buy'] = $trade->getBuy();
            $totalTokensTrades[$trade->getToken()]['balance'] = $trade->getBalance();
        }
        // dd($totalTokensTrades);
        //  dd($token);
        if ($form->isSubmitted() && $form->isValid()) {

            // Make Select request to Data Base (Trade Entity) with parameters from form
            $trade = $form->getData();

            if ($trade->getAction() == null && $trade->getToken() == null && $trade->getExchange() == null) {

                $trade = $entityManager->getRepository(Trade::class)->findAll();
            } else if ($trade->getAction() == null && $trade->getToken() !== null && $trade->getExchange() !== null) {

                $trade = $entityManager->getRepository(Trade::class)->findBy(
                    [
                        'token' => $trade->getToken(),
                        'exchange' => $trade->getExchange(),
                    ]
                );
            } else if ($trade->getAction() !== null && $trade->getToken() == null && $trade->getExchange() !== null) {

                $trade = $entityManager->getRepository(Trade::class)->findBy(
                    [
                        'action' => $trade->getAction(),
                        'exchange' => $trade->getExchange(),
                    ]
                );
            } else if ($trade->getAction() !== null && $trade->getToken() !== null && $trade->getExchange() == null) {

                $trade = $entityManager->getRepository(Trade::class)->findBy(
                    [
                        'action' => $trade->getAction(),
                        'token' => $trade->getToken(),
                    ]
                );
            } else if ($trade->getAction() == null && $trade->getToken() !== null && $trade->getExchange() == null) {

                $trade = $entityManager->getRepository(Trade::class)->findBy(
                    [
                        'token' => $trade->getToken(),
                    ]
                );
            } else if ($trade->getAction() == null && $trade->getToken() == null && $trade->getExchange() !== null) {

                $trade = $entityManager->getRepository(Trade::class)->findBy(
                    [
                        'exchange' => $trade->getExchange(),
                    ]
                );
            } else if ($trade->getAction() !== null && $trade->getToken() == null && $trade->getExchange() == null) {

                $trade = $entityManager->getRepository(Trade::class)->findBy(
                    [
                        'action' => $trade->getAction(),
                    ]
                );
            } else {

                $trade = $entityManager->getRepository(Trade::class)->findBy(
                    [
                        'action' => $trade->getAction(),
                        'token' => $trade->getToken(),
                        'exchange' => $trade->getExchange(),
                    ]
                );
            }
            return $this->render('main/index.html.twig', [
                'form' => $form->createView(),
                'trades' => $trade,
                'tokens' => $token,
                'totalTokensTrades' => $totalTokensTrades,
            ]);

            // Search for Trade with token and exchange in parameters

            // If Trade not found, make alert message
            // if (!$trade) {
            //     $this->addFlash('danger', 'Trade not found');
            // }
            return $this->redirectToRoute('app_main');
        }



        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'form' => $form->createView(),
            'trades' => $trade,
            'tokens' => $token,
            'totalTokensTrades' => $totalTokensTrades,
            // 'totalSell' => $entityManager->getRepository(Trade::class)->getTotalSell(),
            // 'totalBuy' => $entityManager->getRepository(Trade::class)->getTotalBuy(),
        ]);
    }
}
