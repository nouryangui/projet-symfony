<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Livre;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/admin/categorie")
 */

class CategorieController extends AbstractController
{
    /**
     * @Route("/", name="categorie_index", methods={"GET"})
     */
    public function index(CategorieRepository $categorieRepository): Response
    {
        return $this->render('categorie/index.html.twig', [
            'titre'=>'Catégories',
            'soustitre' => '',
            'lien'=>$this->generateUrl('categorie_index'),
            'categories' => $categorieRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="categorie_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($categorie);
            $entityManager->flush();

            return $this->redirectToRoute('categorie_index');
        }

        return $this->render('categorie/new.html.twig', [
            'categorie' => $categorie,
            'form' => $form->createView(),'lien' => $this->generateUrl('categorie_new'), 'titre' => 'Categories',
            'soustitre' => 'Ajouter',
        ]);
    }

    /**
     * @Route("/{id}", name="categorie_show", methods={"GET"})
     */
    public function show(Categorie $categorie): Response
    {
        return $this->render('categorie/show.html.twig', [
            'categorie' => $categorie,
            'titre'=>'catégorie',
            'soustitre'=>'details',
            'lien'=>$this->generateUrl('categorie_index'),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="categorie_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Categorie $categorie): Response
    {
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('categorie_index');
        }

        return $this->render('categorie/edit.html.twig', [
            'categorie' => $categorie,
            'lien' => $this->generateUrl('categorie_index'), 'titre' => 'Categories',
            'soustitre' => 'Editer',
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/delete/{id}", name="categorie_delete")
     */
    public function delete(Request $request, int $id = -1): Response
    {
        if ($id <= 0) {
            return $this->redirectToRoute('categorie_index');
        } else {
            $rep = $this->getDoctrine()->getRepository(Categorie::class);
            $categroire = $rep->findOneBy(['id' => $id]);
            $em = $this->getDoctrine()->getManager();
            $em->remove(     $categroire );
            $em->flush();
            return $this->redirectToRoute('categorie_index');
        }

    }
}
