<?php

namespace App\Controller;

use App\Entity\Emprunter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\EmprunterType;

/**
 * @Route("/emprunter")
 */
class EmprunterController extends AbstractController
{


    /**
     * @Route("/new", name="emprunter_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $emprunt = new Emprunter();
        $form = $this->createForm(EmprunterType::class, $emprunt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($emprunt);
            $entityManager->flush();

            return $this->redirectToRoute('emprunter_new');
        }

        return $this->render('emprunter/nouveau.html.twig', [

            'form' => $form->createView(),
            'titre'=>'Livres',
            'soustitre'=>'Details',
            'lien'=>$this->generateUrl('emprunter_new'),
        ]);
    }
}
