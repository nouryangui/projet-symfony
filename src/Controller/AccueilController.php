<?php

namespace App\Controller;

use App\Entity\Auteur;
use App\Entity\Categorie;
use App\Entity\Editeur;
use App\Entity\Livre;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    /**
     * @Route("/accueil", name="accueil")
     */
    public function index(): Response
    {$lien=$this->generateUrl("accueil");
        $nbauteurs=count($this->getDoctrine()->getRepository(Auteur::class)->findAll());
        $nblivres=count($this->getDoctrine()->getRepository(Livre::class)->findAll());
        $nbcategories=count($this->getDoctrine()->getRepository(Categorie::class)->findAll());
        $nbediteurs=count($this->getDoctrine()->getRepository(Editeur::class)->findAll());
        return $this->render('accueil/index.html.twig',['nbauteurs'=>$nbauteurs,'titre'=>'accueil','lien'=>$lien,'soustitre'=>'','nblivres'=> $nblivres,'nbcategories'=>$nbcategories,'nbediteurs'=> $nbediteurs],);
    }
}
