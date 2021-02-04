<?php

namespace App\Controller\Admin;

use App\Entity\Size;
use App\Entity\User;
use App\Entity\Gender;
use App\Entity\Invoice;
use App\Entity\Product;
use App\Entity\Category;
use App\Controller\Admin\SizeCrudController;
use App\Controller\Admin\UserCrudController;
use App\Controller\Admin\GenderCrudController;
use Symfony\Component\HttpFoundation\Response;
use App\Controller\Admin\ProductCrudController;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\Admin\CategoryCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $routeBuilder = $this->get(CrudUrlGenerator::class)->build();

        return $this->redirect($routeBuilder->setController(ProductCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Nanga Def - Administration')
            ->setTranslationDomain('fr')
            ->setFaviconPath('../../../assets/images/favicon.png');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToUrl('Aller sur le site', 'fas fa-desktop', '/');
        yield MenuItem::section('Gestion de la clientèle');
        yield MenuItem::linkToCrud('Clients', 'fas fa-user-friends', User::class)
        ->setController(UserCrudController::class);
        yield MenuItem::linkToCrud('Détails', 'fas fa-asterisk', Invoice::class);
        yield MenuItem::section('Gestion des produits');
        yield MenuItem::linkToCrud('Produits', 'fas fa-tshirt', Product::class)
                        ->setController(ProductCrudController::class);
        yield MenuItem::linkToCrud('Genres', 'fas fa-transgender', Gender::class)
        ->setController(GenderCrudController::class);
        yield MenuItem::linkToCrud('Tailles', 'fas fa-people-arrows', Size::class)
        ->setController(SizeCrudController::class);
        yield MenuItem::linkToCrud('Categories', 'fas fa-list', Category::class)
        ->setController(CategoryCrudController::class);
    }
}
