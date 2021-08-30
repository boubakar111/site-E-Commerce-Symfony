<?php

namespace App\Services;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PanierService
{
    private $session;
    private $repoProduct;
    private $tva = 0.2;

    public function __construct(SessionInterface $session, ProductRepository $repoProduct)
    {
        $this->session = $session;
        $this->repoProduct = $repoProduct;
    }


    // ajouter un produit au panier
    public function addToPanier($id)
    {
        // recuperer le panier
        $panier = $this->getPanier();
        //si le produit existe dans le panier en incrimente le produit
        if (isset($panier[$id])) {
            $panier[$id]++;
        } else {
            // s'il n'exiiste pas dans le panier en le cree
            $panier[$id] = 1;
        }
        // metre ajour le panier
        $this->updatePanier($panier);
    }


    //recuprer le panier si non  un tableau vid
    public function getPanier()
    {
        return $this->session->get('panier', []);
    }

    //supprimer un produit du panier 

    public function updatePanier($panier)
    {
        $this->session->set('panier', $panier);
        $this->session->set('cartData' , $this->getFullPanier());
    }


// récupérer la totalité du panier
    public function getFullPanier()
    {
        $panier = $this->getPanier();
        $fullPanier = [];
        foreach ($panier as $id => $quantity) {
            $product = $this->repoProduct->find($id);
            if ($product) {
                $fullPanier[] = [
                    'quantity' => $quantity,
                    'product' => $product,
                ];

            } else {
                //id incorrecte , porduit n'existe pas
                $this->deleteFromPanier($id);
            }

        }

        return $fullPanier;
    }

    //supprimer totalement  tous les produit du panier

    public function deleteFromPanier($id)
    {
        $panier = $this->getPanier();
        //si le produit est deja dans le panier
        if (isset($panier[$id])) {
            //si le produit existe plus d'une fois
            if ($panier[$id] > 1) {
                $panier[$id]--;
            } else {
                //s'il egale a un en le supprimer du panier
                unset($panier[$id]);
            }
            $this->updatePanier($panier);
        }
    }


    public function deleteProductFromPanier($id)
    {
        $panier = $this->getPanier();
        //si produit existe dans le panier  en le supprimer
        if (isset($panier[$id])) {
            unset($panier[$id]);

            $this->updatePanier($panier);
        }

    }

    //recuper tout le panier  avec les produit et la quantity
    public function deletePanier()
    {
        $this->updatePanier([]);
    }


    //total du panier
    public function totalPnier($panier)
    {
        $total = 0;
        foreach ($panier as $produit) {
            $prix = $produit['product']->getPrix();
            $total += $produit['quantity'] * ($produit['product']->getPrix() / 100);;
        };
        return $total;
    }
}

?>