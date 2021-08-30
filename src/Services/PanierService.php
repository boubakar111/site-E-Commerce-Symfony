<?php
namespace App\Services;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PanierService{
    private $session;
    private $repoProduct;
    private $tva = 0.2;

    public function __construct(SessionInterface   $session , ProductRepository  $repoProduct)
    {
        $this->session = $session;
        $this->repoProduct = $repoProduct;
    }

    // ajouter un produit au panier
    public function addToPanier($id){
        $panier = $this->getPanier();
        //si le produit existe dans le panier en incrimente le produit
        if(isset($panier[$id])){
            $panier[$id]++;
        }else{
            // s'il n'exiiste pas dans le panier en le cree
            $panier[$id]=1;
        }
        $this->updatePanier($panier);
    }

   //metre a jour le pnaier
    public function updatePanier($panier){

       $this->session->set('panier',$panier);
       //mettre le panier dans une session
        $this->session->set('sessionPanier',$this->getFullPanier());
    }

    //supprimer un produit du panier 
    public function deleteFromPanier($id){
        $panier = $this->getPanier();
         //si le produit est deja dans le panier
        if(isset($panier[$id])){
            //si le produit et superieur a un
            if($panier[$id] > 1){
                $panier[$id]--;
            }else{
                //s'il egale a un en le supprimer du panier
                unset($panier[$id]);
            }
            $this->updatePanier($panier);
        }
    }
// supprimer produit totalemnt  du  pnaier
    public function deleteAllPanier($id){
        $panier = $this->getPanier();
        //si produit existe dans le panier  en le supprimer
        if(isset($panier[$id])) {
            unset($panier[$id]);
            $this->updatePanier($panier);
        }

    }

    //supprimer totalement  tous les produit du panier
    public function deletePanier(){
        $this->updatePanier([]);
    }

    public function  getPanier(){
        return $this->session->get('panier',[]);
    }

    //recuper tout le panier  avec les produit et la quantity
    public function getFullPanier()
    {
        $panier = $this->getPanier();

        $fullPanier = [];
        foreach ($panier as $id => $quantity )
        {
            $product = $this->repoProduct->find($id);
            if ($product)
            {
                $fullPanier['products'][]=[
                    'quantity'=>$quantity,
                    'product'=>$product,
                ];

            }else{
                $this->deleteFromPanier($id);
            }

        }

        return $fullPanier;
    }
 //total du panier
     public function totalPnier($panier){

         $total = 0;
         foreach ($panier as   $produit ){
             $prix = $produit['product']->getPrix();
             $total +=  $produit['quantity'] * ($produit['product']->getPrix()/100); ;

         };
         return $total;
     }
}
?>