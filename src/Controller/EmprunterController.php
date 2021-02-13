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
