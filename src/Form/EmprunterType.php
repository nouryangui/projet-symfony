<?php

namespace App\Form;

use App\Entity\Emprunter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmprunterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

           // ->add('dateDebut',DateType::class,['widget'=>'single_text'])
          //  ->add('dateFin',DateType::class,['widget'=>'single_text'])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Emprunter::class,
        ]);
    }
}
