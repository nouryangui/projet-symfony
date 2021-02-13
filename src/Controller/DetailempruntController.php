<?php

namespace App\Controller;

use App\Entity\Editeur;
use App\Entity\User;
use App\Repository\EmprunterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DetailempruntController extends AbstractController
{
    /**
     * @Route("/detailemprunt/{abonne}", name="detailemprunt")
     */
    public function findEmpruntsByUser(EmprunterRepository $emprunterRepository,$abonne=-1): Response
    {
        $rep1 = $this->getDoctrine()->getRepository(User::class);
        $user = $rep1->findOneById($abonne);
        return $this->render('detailemprunt/index.html.twig',['emprunts' => $emprunterRepository->findByUser($abonne),
          ]);
    }
    /**
     * @Route("/delete/emprunter/{id}/{abonne}", name="emprunt_delete")
     */
    public function delete(Request $request, int $id = -1,EmprunterRepository $emprunterRepository,int $abonne=-1): Response
    {
        if ($id <= 0) {

            return $this->redirectToRoute('detailemprunt');
        } else {



            $emprunt = $emprunterRepository->findOneBy(['id' => $id]);
            echo $emprunt->getId();
            $em = $this->getDoctrine()->getManager();
            $em->remove($emprunt);
            $em->flush();
            return $this->redirectToRoute('detailemprunt',['abonne'=>$abonne]);
        }

    }
}
