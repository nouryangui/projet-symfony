<?php

namespace App\Controller;

use App\Repository\LivreRepository;
use App\Repository\LivreRepository\Repository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LivrefrontController extends AbstractController
{
    /**
     * @Route("/livrefront", name="livrefront")
     */
    public function index(LivreRepository $livreRepository): Response
    {
        return $this->render('livrefront/index.html.twig', [

            'livres' => $livreRepository->findAll(),
        ]);
    }
}
