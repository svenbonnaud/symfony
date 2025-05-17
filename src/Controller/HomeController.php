<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        // Affiche les messages d'erreur (ex: mauvais mot de passe, accès refusé, etc.)
        $errors = $this->get('session')->getFlashBag()->all();
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'errors' => $errors,
        ]);
    }
}
