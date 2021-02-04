<?php

namespace App\Controller;

use App\Entity\Command;
use App\Repository\CommandRepository;
use App\Repository\InvoiceRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountController extends AbstractController
{
    /**
     * @Route("/moncompte", name="account")
     */
    public function index(): Response
    {
        return $this->render('account/index.html.twig');
    }

    /**
     * @Route("commandes/historique", name="commands_all")
     */
    public function allCommands(
        CommandRepository $commandRepository,
        Request $request
    ) {
        $commands = $commandRepository->findBy(
            ['user' => $this->getUser()],
            ['id' => 'DESC'],
        );


        return $this->render('account/orders.html.twig', [
            'commands' => $commands
        ]);
    }

    /**
     * @Route("commande/{id}", name="command_one")
     */
    public function showOneCommand(Command $command, InvoiceRepository $invoiceRepository)
    {
        if ($command->getUser() !== $this->getUser()) {
            throw $this->createNotFoundException();
        }

        $products = $invoiceRepository->findBy(['command' => $command]);
        return $this->render('account/show_order.html.twig', [
            'command' => $command,
            'products' => $products
        ]);
    }
}
