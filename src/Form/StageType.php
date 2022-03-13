<?php

namespace App\Form;

use App\Entity\Stage;
use App\Entity\Formation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Form\EntrepriseType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class StageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class)
            ->add('mission', TextareaType::class)
            ->add('email', EmailType::class)
            ->add('entreprise', EntrepriseType::class)
            ->add('typeFormation', EntityType::class, array(
                'class' => Formation::class,
                'choice_label' => function(Formation $formation)
                {return $formation->getTitre();},
                // used to render a select box, check boxes or radios
                'multiple' => true,
                'expanded' => true,
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Stage::class,
        ]);
    }
}
