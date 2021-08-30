<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(ProductRepository $repoProduct): Response
    {
        $product = $repoProduct->findAll();
        $productNewAreval  = $repoProduct->findByIsNewArival(1);
        $productBestSeller = $repoProduct->findByIsBestSeller(1);
        $productFeatured   = $repoProduct->findByIsFeatured(1);
        $roductSpecialOffer= $repoProduct->findByIsSpecialOffer(1);
        return $this->render('home/index.html.twig', [
            'products'=> $product,
            'productNewAreval'   =>  $productNewAreval,
            'productFeatured'    => $productFeatured,
            'roductSpecialOffer' =>  $roductSpecialOffer,
            'productBestSeller'  =>   $productBestSeller,
        ]);
    }

    /**
     * @Route("/detail{slug}", name="product_detail")
     */

    public function showProduct( ? Product  $product): Response {

         if(!$product){
             return $this->redirectToRoute('home');
         }

         return $this->render('home/detail_product.html.twig', [
             'product'=> $product
         ]);
    }
}
