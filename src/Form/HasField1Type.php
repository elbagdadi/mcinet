<?php

namespace App\Form;

use App\Entity\HasField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HasField1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('field_label')
            ->add('field_type')
            ->add('true_value')
            ->add('options')
            ->add('selector_id')
            ->add('selector_classes')
            ->add('selector_placeholder')
            ->add('secteur')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => HasField::class,
        ]);
    }
}
