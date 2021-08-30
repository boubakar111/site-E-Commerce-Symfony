<?php

namespace App\Controller;

use App\Services\PanierService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    public function __construct( PanierService  $panierService)
    {
        return $this->panierService = $panierService;
    }

    /**
     * @Route("/panier", name="panier")
     */
    public function index(): Response
    {
        $panier = $this->panierService->getFullPanier();
        $total = $this->panierService->totalPnier();
        //si le panier et vide 
        if(!$panier){
            return $this->redirectToRoute('home');
        }
        return $this->render('panier/index.html.twig', [
           'panierProduit'=>$panier ,
            'total'=>$total

        ]);
    }

    /**
     *
     * @Route("/panier/add/{id}" , name ="add_panier")
     */

    public function addPanier($id  ): Response{

        $this->panierService->addToPanier($id);
        return $this->redirectToRoute('panier');

    }


    /**
     *
     * @Route("/panier/delete/{id}" , name ="delete_panier")
     */

    public function deleteFromPanier($id): Response{

        $this->panierService->deleteFromPanier($id);
        return $this->redirectToRoute('panier');
    }

    /**
     *
     * @Route("/panier/deleteAll/{id}" , name ="delete_All_panier")
     */
    public function delateAllFromPnier($id){
        $this->panierService->deleteAllPanier($id);
        return  $this->redirectToRoute('panier');
    }

}
