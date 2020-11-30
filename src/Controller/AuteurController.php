<?php

namespace App\Controller;

use App\Entity\Auteur;
use App\Form\AuteurType;
use App\Repository\AuteurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/auteur")
 */
class AuteurController extends AbstractController
{
    /**
     * @Route("/", name="index_auteur")
     */
    public function index(): Response
    {
        $rep = $this->getDoctrine()->getRepository(Auteur::class);
        $auteurs = $rep->findAll();
        return $this->render('auteur/index.html.twig', [
            'auteurs' => $auteurs,
        ]);
    }

    /**
     * @Route("/nouveau", name="nouvel_auteur")
     */
    public function nouveau(Request $request)
    {
        $auteur = new Auteur();
        $frm = $this->createForm(AuteurType::class, $auteur);
        $frm->add('valider', SubmitType::class);
        $frm->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        if ($frm->isSubmitted() && $frm->isValid()) {
            $em->persist($auteur);
            $em->flush();
            return $this->redirectToRoute('nouvel_auteur');

        }
        return $this->render('auteur/nouveau.html.twig', ['formulaire' => $frm->createView()]);
    }

    /**
     * @Route("/afficher/{id}", name="afficher_auteur")
     */
    public function afficher(int $id)
    {

        $rep = $this->getDoctrine()->getRepository(Auteur::class);
        $auteur = $rep->findOneBy(['id' => $id]);
        return $this->render('auteur/afficher.html.twig', ['auteur' => $auteur]);
    }

    /**
     * @Route("/edit/{id}", name="edit_auteur")
     */
    public function editer(int $id, Request $request)
    {
        if ($id <= 0) {
            return $this->redirectToRoute('index_auteur');
        } else {
            $rep = $this->getDoctrine()->getRepository(Auteur::class);
            $auteur = $rep->findOneBy(['id' => $id]);
            $frm = $this->createForm(AuteurType::class, $auteur);
            $frm->add('modifier', SubmitType::class);
            $frm->handleRequest($request);
            if ($frm->isSubmitted() && $frm->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->flush();
                return $this->redirectToRoute('index_auteur');
            }


            return $this->render('auteur/edit.html.twig', ['frm' => $frm->createView()]);
        }

    }

    /**
     * @Route("/supprimer/{id}", name="supprimer_auteur")
     */
    public function supprimer(int $id=-1)
    {
        if ($id <= 0) {
            return $this->redirectToRoute('index_auteur');
        } else {
            $rep = $this->getDoctrine()->getRepository(Auteur::class);
            $auteur = $rep->findOneBy(['id' => $id]);
            $em = $this->getDoctrine()->getManager();
            $em->remove($auteur);
            $em->flush();
            return $this->redirectToRoute('index_auteur');
        }

    }
}
