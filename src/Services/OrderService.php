<?php

namespace App\Services;

use App\Entity\Order;
use App\Entity\OrderDetaiils;
use App\Entity\Panier;
use App\Entity\PanierDetails;
use Doctrine\ORM\EntityManagerInterface;

class OrderService
{

    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     *
     */
    public function createOrder($panier)
    {
        $order = new Order();
        $order->setReference($panier->getReference())
            ->setTransproteurName($panier->getTransporteurName())
            ->setTransportPrice($panier->getTransporteurPrice())
            ->setAdresseLivraison($panier->getAdresseLivraison())
            ->setMoreInformations($panier->getMoreInformations())
            ->setQuantity($panier->getQuantity())
            ->setSubTotalHt($panier->getSubTotalHt())
            ->setTaxe($panier->getTaxe())
            ->setSubTotalTTC($panier->getSubTotalTTC())
            ->setUser($panier->getUser())
            ->setCreatedAt($panier->getCreatedAt());
        $this->manager->persist($order);

        $products = $panier->getPanierdetails()->getValues();
        //recuperer le detail du panier pour passer la commande
        foreach ( $products as $panier_product){

            $orderDetail = new OrderDetaiils();
            $orderDetail->setOrders( $order)
                ->setProductName($panier_product->getProductName())
                ->setProductPrice($panier_product->getProductPrice())
                ->setQuantity($panier_product->getQuantity())
                ->setSubTotalHt($panier_product->getSubTotalHt())
                ->setSubTotalTTC($panier_product->getSubTotalTTC())
                ->setTaxe($panier_product->getTaxe());
            $this->manager->persist($orderDetail);
        }
        $this->manager->flush();
        return $order;
    }

    public function savePanier($data, $user)
    {
        $panier = new Panier();
        $referfance = $this->generateUuid();
        $adresse = $data['checkout']['adresse'];
        $transporteur = $data['checkout']['transporteur'];
        $information = $data['checkout']['information'];

        $panier->setReference($referfance)
            ->setTransproteurName($transporteur->getName())
            ->setTransportPrice($transporteur->getPrice())
            ->setFullName($adresse->getFullname())
            ->setAdresseLivraison($adresse)
            ->setMoreInformations($information)
            ->setQuantity($data['data']['quantityPanier'])
            ->setSubTotalHT($data['data']['subTotalHT'])
            ->setSubTotalTTC($data['data']['totalTTC'])
            ->setTaxe($data['data']['taxe'])
            ->setSubTotalTTC(round($data['data']['totalTTC'] + $transporteur->getPrice() / 100), 2)
            ->setUser($user)
            ->setCreatedAt(new \DateTime());
        $this->manager->persist($panier);

        //creation du details du panier

        $detail_panier_array = [];
        foreach ($data['products'] as $products) {
            $detailPanier = new PanierDetails();
            $subtotal = $products['quantity'] * $products['product']->getPrix() / 100;

            $detailPanier->setPaniers($panier)
                ->setProductName($products['product']->getName())
                ->setProductPrice($products['product']->getPrix() / 100)
                ->setQuantity($products['quantity'])
                ->setSubTotalHt($subtotal)
                ->setSubTotalTTC($subtotal * 1.2)
                ->setTaxe($subtotal * 0.2);
            $this->manager->persist($detailPanier);
            $detail_panier_array[] = $detailPanier;
        }
        $this->manager->flush();

        return $referfance;
    }

    /**
     * @return string elle tetourne un identifiant unique  pour un panier
     *
     */
    public function generateUuid()
    {
        // initialiser le générateur de nombres aléatoires Mesenne twister
        mt_srand((double)microtime() * 100000);
        // elle renvoir une chaine de charactere en Majuscul
        // uniqid renvoir un id unique
        $charid = strtoupper(md5(uniqid(rand(), true)));
        //générer une chaine d'un octer à partir d'un nombre
        $hyphen = chr(45);
        // substr retourne  un segment de chaine
        $uuid = ""
            . substr($charid, 0, 8) . $hyphen
            . substr($charid, 8, 4) . $hyphen
            . substr($charid, 12, 4) . $hyphen
            . substr($charid, 16, 4) . $hyphen
            . substr($charid, 20, 12);
        return $uuid;
    }

}

