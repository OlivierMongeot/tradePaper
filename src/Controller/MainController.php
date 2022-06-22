<?php

namespace App\Controller;

use App\Entity\Token;
use App\Entity\Trade;
use App\Entity\TotalTrade;
use App\Entity\Configuration;
use App\Parser\TradeAgregator;
use App\Form\ConfigurationType;
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
        // Configure form
        $config = new Configuration();
        $form = $this->createForm(ConfigurationType::class, $config);
        $form->handleRequest($request);

        $entityManager = $this->getDoctrine()->getManager();

        $allTrades = $entityManager->getRepository(Trade::class)->findAll();

        $agregator = new TradeAgregator();
        $tradesByToken = $agregator->agregateData($allTrades);
 

        if ($form->isSubmitted() && $form->isValid()) {

            // Persist the last configuration (index 0)
            $configuration = $entityManager->getRepository(Configuration::class)->findAll();
            $configuration[0]->setStartDate($config->getStartDate());
            $configuration[0]->setEndDate($config->getEndDate());
            $configuration[0]->setToken($config->getToken());
            $configuration[0]->setExchange($config->getExchange());
            $entityManager->persist($configuration[0]);
            $entityManager->flush();


            // Make Select request to Data Base (Trade Entity) with parameters from form
            $allTrades = $entityManager->getRepository(Trade::class)->getBetweenDates($config->getStartDate(), $config->getEndDate(), $config->getToken(), $config->getExchange());
            $agregator = new TradeAgregator();
            $tradesByToken = $agregator->agregateData($allTrades);
     

            return $this->render('main/index.html.twig', [
                'form' => $form->createView(),
                'allTrades' => $tradesByToken[0],
                'totalTrades' => $tradesByToken[1],
                'configuration' => $configuration[0]
            ]);
        }

        return $this->render('main/index.html.twig', [
            'form' => $form->createView(),
            'allTrades' => $tradesByToken[0],
            'totalTrades' => $tradesByToken[1],
            'configuration' => []
        ]);
    }
}
