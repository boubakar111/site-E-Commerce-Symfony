<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CguController extends AbstractController
{
    /**
     * @Route("/condition_general_U", name="CGU_consulte")
     */
    public function index(): Response
    {
        return $this->render('cgu/index.html.twig', [

        ]);
    }
}
