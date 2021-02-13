<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Emprunter;
use App\Entity\Livre;
use App\Entity\User;
use App\Form\EmprunterType;
use App\Repository\EmprunterRepository;
use App\Repository\LivreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DateInterval;
use DateTime;
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
    /**
     * @Route("/new/{id}/{abonne}", name="livre")
     */
    public function new(Request $request, $id=-1,$abonne=-1,EmprunterRepository $emprunterRepository): Response
    {
        $verifier = true;
        $rep = $this->getDoctrine()->getRepository(Livre::class);
        $livre = $rep->findOneById($id);
        $rep1 = $this->getDoctrine()->getRepository(User::class);
        $user = $rep1->findOneById($abonne);
        $emprunt = new Emprunter();
        $emprunt->setLivre($livre);
        $emprunt->setUser($user);
        $emprunt->setDateDebut(new \DateTime('now'));
        $datefin = new \DateTime('now');
        $datefin->add(new DateInterval('P15D'));
        $emprunt->setDateFin($datefin);




            if ($livre->getNombreExamplaires() == 1) {
                $this->addFlash(
                    'notice',
                    'le nombre exemplaires du livre: ' . $livre->getTitre() . ' egale à 1'
                );


            } else {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($emprunt);
                $livre->setNombreExamplaires($livre->getNombreExamplaires() - 1);

                $entityManager->flush();
                $this->redirectToRoute('detailemprunt');

            }



      return $this->render('/detailemprunt/index.html.twig', ['emprunts' => $emprunterRepository->findByUser($abonne),
          ]


        );

    }
}
