<?php

namespace App\Form;

use App\Entity\Bankcard;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class BankcardType extends AbstractType
{
    protected $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($this->security->isGranted('ROLE_ADMIN')) {
            $builder
                ->add('accountnr')
                ->add('bank')
                ->add('cardnr')
                ->add('userId');
        } elseif ($this->security->isGranted('ROLE_USER')) {
            $builder
                ->add('accountnr')
                ->add('bank')
                ->add('cardnr');
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Bankcard::class,
        ]);
    }
}
