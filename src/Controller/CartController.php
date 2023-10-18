<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Piece;
use App\Repository\PieceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/panier', name:'cart_')]
class CartController extends AbstractController
{
    #[Route('/', name: 'list')]
    public function list(SessionInterface $session, PieceRepository $pieceRepository): Response
    {
        $panier = $session->get('panier', []);
        $dataPanier = [];
        $total = 0;

        foreach($panier as $id=> $quantite){
            $piece = $pieceRepository->find($id);
            $dataPanier[]= [
                "piece"=> $piece,
                "quantite"=> $quantite
            ];
            $total += $piece->getPcePrice() * $quantite;
        }
        return $this->render('cart/index.html.twig', compact('dataPanier', 'total')
        );
    }

    #[Route('/ajout/{id}', name: 'add')]
    public function add(Piece $piece, SessionInterface $session): Response
    {
        $panier = $session->get('panier', []);
        $id = $piece->getId();

        if(!empty($panier[$id])){
            $panier[$id]++;
        } else {
            $panier[$id]=1;
        }
        $session->set('panier', $panier);

        return $this->redirectToRoute("cart_list");
    }

    #[Route('/remove/{id}', name: 'remove')]
    public function remove(Piece $piece, SessionInterface $session): Response
    {
        $panier = $session->get('panier', []);
        $id = $piece->getId();

        if(!empty($panier[$id])){
            if($panier[$id] > 1){
                $panier[$id]--;
            }else{
                unset($panier[$id]);
            }
        }
        $session->set('panier', $panier);

        return $this->redirectToRoute("cart_list");
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function delete(Piece $piece, SessionInterface $session): Response
    {
        $panier = $session->get('panier', []);
        $id = $piece->getId();

        if(!empty($panier[$id])){
                unset($panier[$id]);
        }
        $session->set('panier', $panier);

        return $this->redirectToRoute("cart_list");
    }

    #[Route('/commande', name: 'order')]
    public function order(SessionInterface $session, PieceRepository $pieceRepository): Response
    {
        $panier = $session->get('panier', []);
        $dataPanier = [];
        $total = 0;

        foreach($panier as $id=> $quantite){
            $piece = $pieceRepository->find($id);
            $dataPanier[]= [
                "piece"=> $piece,
                "quantite"=> $quantite
            ];
            $total += $piece->getPcePrice() * $quantite;
        }
        return $this->render('cart/order.html.twig', compact('dataPanier', 'total')
        );
    }

}
