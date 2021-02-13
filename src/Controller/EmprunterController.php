<?php

namespace App\Controller;

use App\Entity\Emprunter;
use App\Entity\Livre;
use App\Entity\User;
use App\Repository\CategorieRepository;
use App\Repository\EmprunterRepository;
use App\Repository\UserRepository;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\EmprunterType;
use DateInterval;
use DateTime;
class EmprunterController extends AbstractController
{


    /**
     * @Route("/new/{id}/{abonne}", name="emprunter_new")
     */
    public function new(Request $request, $id=-1,$abonne=-1): Response
    {$verifier = true;
        $rep = $this->getDoctrine()->getRepository(Livre::class);
        $livre = $rep->findOneById($id);
        $rep1 = $this->getDoctrine()->getRepository(User::class);
        $user = $rep1->findOneById($abonne);
        $emprunt = new Emprunter();
        $emprunt->setLivre($livre);
        $emprunt->setUser($user);
        $emprunt->setDateDebut(new \DateTime('now'));
        $datefin = new \DateTime('now');
        $datefin ->add(new DateInterval('P15D'));
        $emprunt->setDateFin($datefin);

        $form = $this->createForm(EmprunterType::class, $emprunt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($livre->getNombreExamplaires() == 1) {
                $this->addFlash(
                    'notice',
                  'le nombre exemplaires du livre: '. $livre->getTitre().' egale à 1'
                );
            }
            else{
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($emprunt);
                $livre->setNombreExamplaires($livre->getNombreExamplaires()-1);

                $entityManager->flush();

                return $this->redirectToRoute('accueil');
            }


        }

        return $this->render('emprunter/nouveau.html.twig', [

            'form' => $form->createView(),
            'titre' => 'Livres',
            'soustitre' => 'Details',
            'lien' => $this->generateUrl('emprunter_new'),
        ]);
    }
    /**
     * @Route("/admin/emprunter", name="emprunt_index", methods={"GET"})
     */
    public function index(EmprunterRepository $emprunterRepository): Response
    {
        return $this->render('emprunter/index.html.twig', [
            'titre'=>'Emprunt',
            'soustitre' => '',
            'lien'=>$this->generateUrl('emprunt_index'),
            'emprunts' => $emprunterRepository->findAll(),
        ]);
    }
    /**
     * @Route("/admin/abonne", name="abonne_index", methods={"GET"})
     */
    public function abonneindex(UserRepository $userRepository): Response
    {
        return $this->render('emprunter/affiche_abonne.html.twig', [
            'titre'=>'Abonne',
            'soustitre' => '',
            'lien'=>$this->generateUrl('abonne_index'),
            'users' => $userRepository->findAll(),
        ]);
    }
}
