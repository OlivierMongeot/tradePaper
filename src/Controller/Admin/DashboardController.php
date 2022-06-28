<?php

namespace App\Controller\Admin;

use App\Entity\Token;
use App\Entity\Trade;
use App\Entity\Users;
use App\Entity\Action;
use App\Entity\Wallets;
use App\Entity\Exchange;
use App\Entity\Configuration;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        // return parent::index();
        return $this->render('admin/dashboard/index.html.twig');
    }

    public function configureDashboard(): Dashboard
    {   
        return Dashboard::new()
        //add link to main page
            ->setTitle('TradingPaper');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section('Blog');
        yield MenuItem::linkToCrud('Exchanges', 'fa fa-comment', Exchange::class);
        yield MenuItem::linkToCrud('Tokens', 'fa fa-file-text', Token::class);
        yield MenuItem::linkToCrud('Actions', 'fas fa-list', Action::class);
        yield MenuItem::linkToCrud('Trades', 'fas fa-list', Trade::class);
        yield MenuItem::linkToCrud('Users', 'fa fa-user', Users::class);
        yield MenuItem::section('Configuration');
        yield MenuItem::linkToCrud('Configuration', 'fa fa-cog', Configuration::class);
        yield MenuItem::linkToCrud('Wallet', 'fa fa-wallet', Wallets::class);
        // link to main page in the bottom menu
        yield MenuItem::linkToRoute('Retour Home', 'fa fa-home', 'app_main')->setCssClass('text-primary');
    }
}
