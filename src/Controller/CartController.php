<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\CartService;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * @Route("/panier", name="cart_")
 */

class CartController extends AbstractController
{
    private $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * @Route("/", name="index")
     */

    public function index(): Response
    {
        $cartInfos = $this->cartService->getCartInfos();
        $total = $this->cartService->getTotalCart();

        return $this->render('cart/index.html.twig', [
            'items' => $cartInfos,
            'total' => $total
        ]);
    }

    /**
     * @Route("/add/{id}", name="add")
     */

    public function add($id)
    {
        $this->cartService->add($id);

        return $this->redirectToRoute('shop');
    }

    /**
     * @Route("/remove/{id}", name="remove")
     */
    public function remove($id)
    {
        $this->cartService->remove($id);

        return $this->redirectToRoute('cart_index');
    }

    /**
     * @Route("/success", name="successcart")
     */

    public function success(SessionInterface $session)
    {
        $session->clear();
        return $this->render('cart/successpage.html.twig');
    }
}
