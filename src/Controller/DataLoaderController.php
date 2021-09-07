<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DataLoaderController extends AbstractController
{
    /**
     * @Route("/data", name="data_loader")
     */
    public function index(EntityManagerInterface $manager): Response
    {
        $file_product = dirname(dirname(__DIR__)) . "\product.json";
        $data_product = json_decode(file_get_contents($file_product));
        $file_categories = dirname(dirname(__DIR__)) . "\category.json";
        $data_category = json_decode(file_get_contents($file_categories));
        dd($data_product);
        $categorie = [];
        foreach ($data_category as $data_categorie) {
            $category = new Category();
            $category->setName($data_categorie[1])
                ->setImage($data_categorie[3]);
            $manager->persist($category);
            $categorie[] = $category;
        }

        foreach ($data_product as $product_data) {
            $product = new Product();
            $product->setName($product_data[1])
                ->setDescription($product_data[2])
                ->setMorInformation($product_data[3])
                ->setPrix($product_data[4])
                ->setIsBestSeller($product_data[5])
                ->setIsNewArival($product_data[6])
                ->setIsFeatured($product_data[7])
                ->setIsSpecialOffer($product_data[8])
                ->setImage($product_data[9])
                ->setQuantity($product_data[10])
                ->setTags($product_data[12])
                ->setSlug($product_data[13])
                ->setCreatedAt(new \DateTime());
            $manager->persist($product);
            $products[] = $product;
        }
        $manager->flush();

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/DataLoaderController.php',
        ]);
    }
}
