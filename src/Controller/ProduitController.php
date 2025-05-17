<?php

// src/Controller/ProduitController.php
namespace App\Controller;

use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Produit;
use App\Form\ProduitTypeForm;

class ProduitController extends AbstractController
{
    #[Route('/produit', name: 'app_produit_index')]
    public function index(ProduitRepository $produitRepository): Response
    {
        $produits = $produitRepository->findAll();

        return $this->render('produit/index.html.twig', [
            'produits' => $produits,
        ]);
    }

    #[Route('/produit/new', name: 'app_produit_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        if (!$this->getUser()) {
            $this->addFlash('error', 'Vous devez être connecté pour créer un produit.');
            return $this->redirectToRoute('app_produit_index');
        }

        $produit = new Produit();

        $form = $this->createForm(ProduitTypeForm::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $produit->setRelation($this->getUser());
            $em->persist($produit);
            $em->flush();

            return $this->redirectToRoute('app_produit_index');
        }

        return $this->render('produit/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
