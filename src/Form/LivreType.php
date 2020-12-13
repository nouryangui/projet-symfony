<?php

namespace App\Form;

use App\Entity\Auteur;
use App\Entity\Livre;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class LivreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('nombrePage')
            ->add('dateEdition', DateType::class, ['widget' => 'single_text'])
            ->add('nombreExamplaires')
            ->add('prix')
            ->add('isbn')
            ->add('imageFile', FileType::class, ['required'=>false])
            ->add('editeur')
            ->add('categorie')
            ->add('auteurs', EntityType::class, [
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
