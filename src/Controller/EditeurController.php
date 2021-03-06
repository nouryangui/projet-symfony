<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Editeur;
use App\Form\EditeurType;
use App\Repository\EditeurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/editeur")
 */

class EditeurController extends AbstractController
{
    /**
     * @Route("/", name="editeur_index", methods={"GET"})
     */
    public function index(EditeurRepository $editeurRepository): Response
    {
        return $this->render('editeur/index.html.twig', [
            'titre'=>'Editeurs',
            'soustitre'=>'',
            'lien'=>$this->generateUrl('editeur_index'),
            'editeurs' => $editeurRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="editeur_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $editeur = new Editeur();
        $form = $this->createForm(EditeurType::class, $editeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($editeur);
            $entityManager->flush();

            return $this->redirectToRoute('editeur_index');
        }

        return $this->render('editeur/new.html.twig', [
            'editeur' => $editeur,
            'lien' => $this->generateUrl('editeur_index'),
            'titre' => 'Editeurs',
            'soustitre' => 'Ajouter',
            'form' => $form->createView(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="editeur_show", methods={"GET"})
     */
    public function show(Editeur $editeur): Response
    {
        return $this->render('editeur/show.html.twig', [
            'editeur' => $editeur,
            'titre'=>'Editeurs',
            'lien'=>$this->generateUrl('editeur_index'),
            'soustitre'=>'Details',
        ]);
    }

    /**
     * @Route("/{id}/edit", name="editeur_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Editeur $editeur): Response
    {
        $form = $this->createForm(EditeurType::class, $editeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('editeur_index');
        }

        return $this->render('editeur/edit.html.twig', [
            'editeur' => $editeur,
            'lien' => $this->generateUrl('editeur_index'), 'titre' => 'Auteurs',
            'soustitre' => 'Editer',
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/delete/{id}", name="editeur_delete")
     */
    public function delete(Request $request, int $id = -1): Response
    {
        if ($id <= 0) {
            return $this->redirectToRoute('editeur_index');
        } else {
            $rep = $this->getDoctrine()->getRepository(Editeur::class);
            $editeur = $rep->findOneBy(['id' => $id]);
            $em = $this->getDoctrine()->getManager();
            $em->remove( $editeur);
            $em->flush();
            return $this->redirectToRoute('editeur_index');
        }

    }
}
