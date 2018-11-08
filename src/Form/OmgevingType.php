<?php

namespace App\Form;

use App\Entity\Omgeving;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OmgevingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('omschrijving')
            ->add('imagepath', FileType::class, array('label' => 'Image', 'data_class' => null, 'required' => false))
            ->add('rating')
            ->add('location')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Omgeving::class,
        ]);
    }
}
