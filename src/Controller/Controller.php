<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Controller extends AbstractController
{
    /**
     * @Route("/", name="app_")
     */
    public function index(): Response
    {
        return $this->render('/main/accueil.html.twig', [
            'controller_name' => 'Controller',
        ]);
    }
}



