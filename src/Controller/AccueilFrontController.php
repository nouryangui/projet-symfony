<?php

namespace App\Controller;


use App\Entity\Categorie;
use App\Entity\Livre;
use App\Repository\CategorieRepository;
use App\Repository\EditeurRepository;
use App\Repository\LivreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AccueilFrontController extends AbstractController
{
    /**
     * @Route("/accueil", name="accueil")
     */
    public function index(CategorieRepository $categorieRepository, EditeurRepository $editeurRepository): Response{

        return $this->render('accueil_front/index.html.twig', [

            'categories' => $categorieRepository->findAll(),'editeurs' => $editeurRepository->findAll(),
            ]);
    }



}
