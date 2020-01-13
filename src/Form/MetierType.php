<?php

namespace App\Form;

use App\Entity\Metier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MetierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom_metier')
            ->add('slug_metier')
            ->add('secteur')
            ->add('nature_du_projet', ChoiceType::class, [
                'choices' => ['Sourcing' => 'sourcing',
                            'Locomotive' => 'locomotive',
                            'Stratégiques et / ou Structurants' => 'strategiques_structurants',
                            'Pionnier' => 'pionnier',
                            'Valorisation des ressources' => 'valorisation_des_ressources'],
            ])
            ->add('ecosystem')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Metier::class,
        ]);
    }
}
