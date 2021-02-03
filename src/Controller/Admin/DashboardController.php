<?php

namespace App\Controller\Admin;

use App\Entity\Size;
use App\Entity\Gender;
use App\Entity\Product;
use App\Entity\Category;
use App\Controller\Admin\SizeCrudController;
use App\Controller\Admin\GenderCrudController;
use Symfony\Component\HttpFoundation\Response;
use App\Controller\Admin\ProductCrudController;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\Admin\CategoryCrudController;
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
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Nanga Def')
            // you can include HTML contents too (e.g. to link to an image)
            ->setTranslationDomain('fr');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToUrl('Aller sur le site', 'fas fa-desktop', '/');
        yield MenuItem::section('Gestion de la clientèle');
        yield MenuItem::section('Gestion des produits');
        yield MenuItem::linkToCrud('Produits', 'fas fa-wifi', Product::class)
                        ->setController(ProductCrudController::class);
        yield MenuItem::linkToCrud('Genres', 'fas fa-times-circle', Gender::class)
        ->setController(GenderCrudController::class);
        yield MenuItem::linkToCrud('Tailles', 'fas fa-times-circle', Size::class)
        ->setController(SizeCrudController::class);
        yield MenuItem::linkToCrud('Categories', 'fas fa-times-circle', Category::class)
        ->setController(CategoryCrudController::class);
    }
}
