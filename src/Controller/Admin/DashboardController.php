<?php

namespace App\Controller\Admin;

use App\Entity\Token;
use App\Entity\Trade;
use App\Entity\Users;
use App\Entity\Action;
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
            ->setTitle('TradingPaper');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Exchanges', 'fa fa-comment', Exchange::class);
        yield MenuItem::linkToCrud('Tokens', 'fa fa-file-text', Token::class);
        yield MenuItem::linkToCrud('Actions', 'fas fa-list', Action::class);
        yield MenuItem::linkToCrud('Trades', 'fas fa-list', Trade::class);
        yield MenuItem::linkToCrud('Users', 'fa fa-user', Users::class);
        yield MenuItem::linkToCrud('Configuration', 'fa fa-cog', Configuration::class);
    }
}
