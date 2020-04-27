<?php

namespace App\Form;

use App\Entity\Cours;
use App\Entity\Seminaire;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SeminaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateDebutSeminaire', DateType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => "datepicker"]
            ])
            ->add('cours', EntityType::class, [
                'class' => Cours::class,
                'label' => 'libelleCours',
                'choice_label' => 'libelleCours',
                'required' => true,
            ])
            ->add('save', SubmitType::class, ['label' => 'Créer']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Seminaire::class,
        ]);
    }
}
