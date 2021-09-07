<?php

namespace App\Controller;

use App\Entity\Adresses;
use App\Form\AdressesType;
use App\Repository\AdressesRepository;
use App\Services\PanierService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/adresses")
 * @IsGranted("ROLE_USER")
 */
class AdressesController extends AbstractController
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @Route("/", name="adresses_index", methods={"GET"})
     */
    public function index(AdressesRepository $adressesRepository): Response
    {

        return $this->render('account/index.html.twig', [
            'adresses' => $adressesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="adresses_new", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function new(Request $request, PanierService $panierService): Response
    {
        $adress = new Adresses();
        $form = $this->createForm(AdressesType::class, $adress);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();

            $adress->setUser($user);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($adress);
            $entityManager->flush();

            if ($panierService->getFullPanier()) {
                return $this->redirectToRoute("checkout");
            }
            $this->addFlash('success', ' nouvelle adresse enregister !');
            return $this->redirectToRoute('adresses_index');
        }

        return $this->render('adresses/new.html.twig', [
            'adress' => $adress,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="adresses_show", methods={"GET"})
     * @IsGranted("ROLE_USER")
     */
    public function show(Adresses $adress): Response
    {
        return $this->render('adresses/show.html.twig', [
            'adress' => $adress,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="adresses_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function edit(Request $request, Adresses $adress): Response
    {
        $form = $this->createForm(AdressesType::class, $adress);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()
                ->getManager()
                ->flush();
            // on vérifie la provenance de  l'action edit ?
            if ($this->session->get('checkout_data')) {
                //actualiser les données de la session suite a lamodification de l'adresse
                $data = $this->session->get('checkout_data');
                $data['adresse'] = $adress;
                $this->session->set('checkout_data', $data);
                return $this->redirectToRoute('checkout_confirme');
            }

            $this->addFlash('success', 'votre asresse a bien ete modifier !');
            return $this->redirectToRoute('adresses_index');
        }

        return $this->render('adresses/edit.html.twig', [
            'adress' => $adress,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="adresses_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Adresses $adress): Response
    {
        if ($this->isCsrfTokenValid('delete' . $adress->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($adress);
            $entityManager->flush();
        }

        return $this->redirectToRoute('adresses_index');
    }
}
