<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrajetSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ligne', TextType::class, [
                'label' => 'Ligne',
                'required' => false,
                'attr' => ['placeholder' => 'Rechercher par ligne'],
            ])
            ->add('pointDepart', TextType::class, [
                'required' => false,
                'label' => 'Départ',
            ])
            ->add('destination', TextType::class, [
                'required' => false,
                'label' => 'Destination',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([]);
    }

    
}
?>
