<?php

namespace App\Controller;

use App\Entity\Size;
use App\Form\SizeType;
use App\Entity\Product;
use App\Entity\Category;
use App\Form\SearchFormType;
use App\Service\CartService;
use App\Data\SearchProductData;
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
        $search = new SearchProductData();
        $searchForm = $this->createForm(SearchFormType::class, $search);
        $searchForm->handleRequest($request);

        $results = [];
        $products = $productRepository->findAll();

        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            $results = $productRepository->searchProduct($search);
        }

        return $this->render('products/index.html.twig', [
            'products' => $results ? $results : $products,
            'searchForm' => $searchForm->createView()
            ]);
    }


    /**
     * @Route("/produits/{slug}", name="product_show")
     * @ParamConverter("product", class="App\Entity\Product", options={"mapping": {"slug": "slug"}})
     */
    public function showProduct(Product $product, ProductRepository $productRepository,  Request $request, CartService $cartService): Response
    {
        $products = $productRepository->findAll();
        $result = [];

        foreach($products as $item)
        {
            if($item->getId() !== $product->getId())
            {
                $result[] = $item;
            }
        }
        
        return $this->render('products/show.html.twig', [
            'product' => $product,   
            'suggestions' => $result,
        ]);
    }
}
