<?php

namespace App\Controller;

use App\Synchroniser\SynchroFullWallet;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SynchroniseWalletController extends AbstractController
{
    /**
     * @Route("/synchronise/wallet", name="app_synchronise_wallet")
     */
    public function index(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $syncroniseWallet = new SynchroFullWallet($entityManager);
        $syncroniseWallet->synchronise();


        return $this->render('synchronise_wallet/index.html.twig', [
            'controller_name' => 'SynchroniseWalletController',
        ]);
    }
}
