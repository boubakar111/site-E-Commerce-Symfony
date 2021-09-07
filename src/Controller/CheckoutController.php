<?php

namespace App\Controller;

use App\Form\CheckoutType;
use App\Form\CkeckoutType;
use App\Services\OrderService;
use App\Services\PanierService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;


class CheckoutController extends AbstractController
{

    private $panierService;
    private $session ;

    public function __construct(PanierService $panierService ,SessionInterface $session)
    {
        $this->panierService = $panierService;
        $this->session = $session;
    }

    /**
     * @Route("/checkout", name="checkout")
     */
    public function index(Request $request): Response
    {
        $user = $this->getUser();
        $panier = $this->panierService->getFullPanier();

        if(!isset($panier['products'])){
            return $this->redirectToRoute('home');
        }

        //voir si le client a rensiginier une adresse
        if (!$user->getAdresses()->getValues()) {
            $this->addFlash('checkout_message', "Merci de renseignier votre adresse avent de finaliser la commande ");
            return $this->redirectToRoute("adresses_new");
        }

        if($this->session->get('checkout_data')){
            return $this->redirectToRoute('checkout_confirme');
        }

        //initilaiser le formulaire
        $form = $this->createForm(CkeckoutType::class, ['user' => $user]);
        return $this->render('checkout/index.html.twig', [
            'panier' => $panier,
            'formCheckout' => $form->createView()
        ]);
    }

    /**
     * methode pour taiter les données  de la page CHEKCOUT
     * @Route ("/checkout/confirme" , name="checkout_confirme")
     *
     */

    public function conformePanier(Request $request ,OrderService  $orderService): Response
    {
        $user = $this->getUser();
        $panier = $this->panierService->getFullPanier();
        //voir si le penier contien un produit
        if (!isset($panier['products'])) {
            //si rien dans le panier en fait une redirection to home
            return $this->redirectToRoute('home');
        }
        //voir si le client a rensiginier une adresse
        if (!$user->getAdresses()->getValues()) {
            $this->addFlash('checkout_message', "Merci de renseignier votre adresse avent de finaliser la commande ");
            return $this->redirectToRoute("adresses_new");
        }

        $form = $this->createForm(CkeckoutType::class, null, ['user' => $user]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() || $this->session->get('checkout_data')) {
            //si nous venons d'une autre page que le formulaire du panier en verifie la session
            if($this->session->get('checkout_data')){
                $data = $this->session->get('checkout_data');
            }else{
                //sinon on ajoute le data recuper du formulaire a notre session
                $data = $form->getData();
                $this->session->set('checkout_data', $data);
            }

            $adresse = $data['adresse'];
            $transporteur = $data['transporteur'];
            $information = $data['information'];
            $panier['checkout'] = $data;

            $referance = $orderService->savePanier($panier , $user);
    dd($referance);

            return $this->render('checkout/confirme.html.twig', [
                'panier' => $panier,
                 'adresse'=>$adresse,
                'transporteur'=>$transporteur,
                'information'=>$information,
            ]);

        }
        return $this->redirectToRoute('ckeckout');
    }

    /**
     * @Route("/checkout/edit" , name="checkout_edit")
     */
    public function checkoutEdit(){
        $this->session->set('checkout_data',[]);
        return $this->redirectToRoute('checkout');

    }

}
