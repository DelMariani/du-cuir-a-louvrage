<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderDetail;
use App\Repository\PieceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/commandes', name: 'app_orders_')]
class OrdersController extends AbstractController
{
    #[Route('/ajout', name: 'add')]
    public function add(SessionInterface $session, PieceRepository $pieceRepository, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $panier = $session->get('panier', []);

        // dd($panier);
        // panier vide
        if($panier === []){
            $this->addFlash('message', 'Votre panier est vide');
            return $this->redirectToRoute('home');
        }

        // panier rempli
        $order = new Order();

        // on remplit la commande
        $order->setOrdNumber(uniqid());

        //on parcourt le panier pour créer la commande
        foreach($panier as $item =>$quantity){
            $orderDetail = new OrderDetail();
            //on va chercher le produit
            $piece = $pieceRepository->find($item);
            $price = $piece->getPcePrice();
            //on crée le détail de commmande
            $orderDetail->setPieces($piece);
            $orderDetail->setPrice($price);
            $orderDetail->setQuantity($quantity);

            $order->addOrderDetail($orderDetail);

        }

        $entityManager->persist($order);
        $entityManager->flush();

        $this->addFlash('message', 'Commande créée avec succès');
        $this->redirectToRoute('main');

        $session->remove('panier');

        return $this->render('orders/index.html.twig', [
            'controller_name' => 'OrdersController',
        ]);
    }
}
