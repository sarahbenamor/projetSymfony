<?php

namespace App\Form;

use App\Entity\Vehicule;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class VehiculeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', TextType::class, [
                'label' => 'Type de Véhicule',
            ])
            ->add('matricule', TextType::class, [
                'label' => 'Matricule',
            ])
            ->add('marque', TextType::class, [
                'label' => 'Marque',
            ])
            ->add('capacite', IntegerType::class, [
                'label' => 'Capacité',
                'attr' => [
                    'min' => 1, 
                ],
            ])
            ->add('statut', ChoiceType::class, [
                'label' => 'Statut',
                'choices' => [
                    'Disponible' => 'disponible',
                    'En maintenance' => 'en maintenance',
                    'Non opérationnel' => 'non opérationnel',
                ],
                'expanded' => true, // Affiche les options comme des boutons radio
                'multiple' => false, // Une seule option peut être sélectionnée
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Vehicule::class,
        ]);
    }
}
