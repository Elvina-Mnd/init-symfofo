<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class ProductController extends AbstractController
{
    /**
     * @Route("/boutique", name="shop")
     */
    public function index(ProductRepository $productRepository, Request $request): Response
    {
        $products = $productRepository->findAll();

        return $this->render('products/index.html.twig', [
            'products' => $products
            ]);
    }

    /**
     * @Route("/produits/{slug}", name="product_show")
     * @ParamConverter("product", class="App\Entity\Product", options={"mapping": {"slug": "slug"}})
     */
    public function showProduct(Product $product): Response
    {
        return $this->render('products/show.html.twig', [
            'product' => $product,     
        ]);
    }
}
