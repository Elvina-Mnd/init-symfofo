<?php

namespace App\Service;

use App\Entity\Command;
use App\Entity\Invoice;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService
{
    private $session;
    private $productRepository;
    private $em;

    public function __construct(
        SessionInterface $session,
        ProductRepository $productRepository,
        EntityManagerInterface $em
    ) {
        $this->session = $session;
        $this->productRepository = $productRepository;
        $this->em = $em;
    }

    public function add($id)
    {
        $panier = $this->session->get('panier', []);
        if (!empty($panier[$id])) {
                $panier[$id]++;
                
            } else {
                $panier[$id] = 1;
            }
            $this->session->set('panier', $panier);
            $count = $this->countProduct();
            $this->session->get('count', []);
            $this->session->set('count', $count);
    }

    public function remove($id)
    {
        $panier = $this->session->get('panier', []);
        if (!empty($panier[$id])) {
                unset($panier[$id]);
        }

            $this->session->set('panier', $panier);

        $count = $this->countProduct();
        $this->session->set('count', $count);
    }

    public function getCartInfos()
    {
        $panier = $this->session->get('panier', []);
        $panierInfos = [];
        foreach ($panier as $id => $quantity) {
            $panierInfos[] = [
            'product' => $this->productRepository->find($id),
            'quantity' => $quantity
            ];
        }
        return $panierInfos;
    }

    public function getTotalCart()
    {
        $total = 0;

        foreach ($this->getCartInfos() as $item) {
            $total += $item['product']->getPrice() * $item['quantity'];
        }
        return $total;
    }

    public function countProduct()
    {
        $total = 0;
        if ($this->getCartInfos() != false) {
            $total = count($this->getCartInfos());
            return $total;
        }
        return $total;
    }

    public function command($user)
    {
        // check of available stock
        // $error = 0;
        // $panier = $this->session->get('panier');


        // command creation
        $command = new Command();

        $command->setTotal($this->getTotalCart());
        $command->setCreatedAt(new \DateTime('now'));
        $command->setUser($user);
        $em = $this->em;
        $em->persist($command);
        $em->flush();

        // invoice product creation
        $invoiceProducts = [];
        foreach ($this->getCartInfos() as $item) {
            $invoiceProduct = new Invoice();
            $invoiceProduct->setProduct($item['product']);
            $invoiceProduct->setCommand($command);
            $invoiceProduct->setQuantity($item['quantity']);
            $invoiceProduct->setPrice($item['product']->getPrice());
            $em = $this->em;
            $em->persist($invoiceProduct);
            $em->flush();
            array_push($invoiceProducts, $invoiceProduct);
        }

        // change quantity available after order
        foreach ($this->getCartInfos() as $item) {
            $updatedProduct = $item['product'];
            $newQty = ($item['product']->getQuantity()) - $item['quantity'];
            $updatedProduct->setQuantity($newQty);
            $em = $this->em;
            $em->persist($updatedProduct);
            $em->flush();
        }

        $this->session->clear();
        return $invoiceProducts;
    }
}