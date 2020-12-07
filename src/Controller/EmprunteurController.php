<?php

namespace App\Controller;

use App\Entity\Emprunteur;
use App\Entity\Livre;
use App\Form\EmprunteurType;
use App\Form\LivreType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/abonne")
 */
class EmprunteurController extends AbstractController
{ /**
 * @Route("/new", name="abonne_new", methods={"GET","POST"})
 */
    public function new(Request $request): Response
    {
        $emprunteur = new Emprunteur();
        $form = $this->createForm(EmprunteurType::class, $emprunteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist( $emprunteur);
            $entityManager->flush();

            return $this->redirectToRoute('abonne_new');
        }

        return $this->render('emprunteur/nouveau.html.twig', [

            'form' => $form->createView(),

        ]);
    }
}
