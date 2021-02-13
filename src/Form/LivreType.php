<?php

namespace App\Form;

use App\Entity\Auteur;
use App\Entity\Categorie;
use App\Entity\Editeur;
use App\Entity\Livre;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class LivreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre',TextType::class,['attr'=>['class'=>'form-control']])
            ->add('nombrePage',NumberType::class,['attr'=>['class'=>'form-control']])
            ->add('dateEdition', DateType::class, ['widget' => 'single_text','attr'=>['class'=>'form-control']])
            ->add('nombreExamplaires',NumberType::class,['attr'=>['class'=>'form-control']])
            ->add('prix',NumberType::class,['attr'=>['class'=>'form-control']])
            ->add('isbn',NumberType::class,['attr'=>['class'=>'form-control']])
            ->add('imageFile', FileType::class, ['required'=>false])
            ->add('editeur',EntityType::class,['attr'=>['class'=>'form-control'],'class'=>Editeur::class,'multiple'=>false,'expanded'=>false])
            ->add('categorie',EntityType::class,['attr'=>['class'=>'form-control'],'class'=>Categorie::class,'multiple'=>false,'expanded'=>false])
            ->add('auteurs', EntityType::class,['attr'=>['class'=>'form-control'] ,
                'class' => Auteur::class,
                'multiple' => true,
                'expanded' => false,
                'choice_label' => function ($auteur) {
            return $auteur->getPrenom()." ".$auteur->getNom();
            }

            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Livre::class,
        ]);
    }
}
