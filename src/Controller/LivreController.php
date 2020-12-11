<?php

namespace App\Controller;

use App\Entity\Auteur;
use App\Entity\Livre;
use App\Form\LivreType;
use App\Repository\LivreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



/**
 * @Route("/admin/livre")
 */

class LivreController extends AbstractController
{
    /**
     * @Route("/", name="livre_index", methods={"GET"})
     */
    public function index(LivreRepository $livreRepository): Response
    {
        return $this->render('livre/index.html.twig', [
            'titre'=>'Livres',
            'lien'=>$this->generateUrl('livre_index'),
            'soustitre'=>'',
            'livres' => $livreRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="livre_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $livre = new Livre();
        $form = $this->createForm(LivreType::class, $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file =  $livre->getPhoto();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('photos_directory'), $fileName);
            $livre->setPhoto($fileName);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($livre);
            $entityManager->flush();

            return $this->redirectToRoute('livre_index');
        }

        return $this->render('livre/new.html.twig', [
            'livre' => $livre,
            'form' => $form->createView(),
            'titre'=>'Livres',
            'soustitre'=>'Details',
            'lien'=>$this->generateUrl('livre_index'),
        ]);
    }

    /**
     * @Route("/{id}", name="livre_show", methods={"GET"})
     */
    public function show(Livre $livre): Response
    {
        return $this->render('livre/show.html.twig', [
            'livre' => $livre,
            'titre'=>'Livres',
            'soustitre'=>'Details',
            'lien'=>$this->generateUrl('livre_index'),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="livre_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Livre $livre): Response
    {
        $form = $this->createForm(LivreType::class, $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('livre_index');
        }

        return $this->render('livre/edit.html.twig', [

            'form' => $form->createView(),
            'lien' => $this->generateUrl('index_auteur'), 'titre' => 'Livres',
            'soustitre' => 'Editer'
        ]);
    }

    /**
     * @Route("/delete/{id}", name="livre_delete")
     */
    public function delete(Request $request, int $id = -1): Response
    {
        if ($id <= 0) {
            return $this->redirectToRoute('index_livre');
        } else {
            $rep = $this->getDoctrine()->getRepository(Livre::class);
            $livre = $rep->findOneBy(['id' => $id]);
            $em = $this->getDoctrine()->getManager();
            $em->remove(   $livre );
            $em->flush();
            return $this->redirectToRoute('livre_index');
        }

    }
}
