<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Livre;
use App\Repository\LivreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LivreFrontController extends AbstractController
{
    /**
     * @Route("/categorie/{id}/livres", name="livre_front")
     */
    public function index(int $id = -1,LivreRepository $livreRepository)
    {
        if ($id <= 0) {
            return $this->redirectToRoute('livre_front"');
        } else {
            $rep = $this->getDoctrine()->getRepository(Categorie::class);
            $categorie = $rep->findOneBy(['id' => $id]);
            $nomctage=  $categorie->getDesignation();
            $livres = $livreRepository->findByCategories($nomctage);

            return $this->render('livre_front/index.html.twig', ['livres' => $livres

            ]);
        }
    }

}
