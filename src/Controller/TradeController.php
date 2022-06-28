<?php

namespace App\Controller;

use App\Entity\Trade;
use App\Entity\Configuration;
use App\Parser\TradeAgregator;
use App\Form\ConfigurationType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TradeController extends AbstractController
{
    /**
     * @Route("/trade", name="app_trade")
     */
    public function index(Request $request): Response
    {
          // Configure form
          $config = new Configuration();
          $form = $this->createForm(ConfigurationType::class, $config);
          $form->handleRequest($request);
  
          $entityManager = $this->getDoctrine()->getManager();
          
          /**
           * @var User $user
           */
            $user = $this->getUser();
      
            // Find all Trade by user id
            $allTradesUser = $entityManager->getRepository(Trade::class)->findBy(array('user' => $user->getId()));
      
          $agregator = new TradeAgregator();
          $tradesByToken = $agregator->agregateData($allTradesUser);
   
  
          if ($form->isSubmitted() && $form->isValid()) {
  
              // update the configuration (index 0)
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
  
              // dd($wallet);
  
              return $this->render('main/trade.html.twig', [
                  'form' => $form->createView(),
                  'allTrades' => $tradesByToken[0],
                  'totalTrades' => $tradesByToken[1],
                  'configuration' => $configuration[0]
              ]);
          }
  
          return $this->render('main/trade.html.twig', [
              'form' => $form->createView(),
              'allTrades' => $tradesByToken[0],
              'totalTrades' => $tradesByToken[1],
              'configuration' => []
          ]);
      }
}
