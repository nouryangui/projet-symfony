<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Editeur;
use App\Repository\LivreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EditeurFrontController extends AbstractController
{

    /**
     * @Route("/editeur/{id}/livres", name="editeur_front")
     */
    public function index(int $id = -1,LivreRepository $livreRepository)
    {
        if ($id <= 0) {
            return $this->redirectToRoute('editeur_front');
        } else {
            $rep = $this->getDoctrine()->getRepository(Editeur::class);
            $editeur= $rep->findOneBy(['id' => $id]);
            $nomctage=  $editeur->getNom();
            $livres = $livreRepository->findByEditeurs($nomctage);

            return $this->render('editeur_front/index.html.twig', ['livres' => $livres

            ]);
        }
    }
}
