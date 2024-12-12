<?php

namespace App\Form;

use App\Entity\Trajet;
use App\Entity\Vehicule;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class TrajetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
{
    $builder
        ->add('type', TextType::class, [
            'label' => 'Type de Trajet',
        ])
        ->add('ligne', TextType::class, [
            'label' => 'Ligne',
        ])
        ->add('pointDepart', TextType::class, [
            'label' => 'Point de Départ',
        ])
        ->add('destination', TextType::class, [
            'label' => 'Destination',
        ])
        ->add('horaire', DateTimeType::class, [
            'label' => 'Horaire',
            'widget' => 'single_text',
            'html5' => true, 
        ])
        ->add('vehicule', EntityType::class, [
            'class' => Vehicule::class,
            'choice_label' => 'type', 
            'label' => 'Véhicule',
            'multiple' => false,
            'expanded' => false,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Trajet::class,
        ]);
    }
}
