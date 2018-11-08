<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class UserType extends AbstractType
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
                ->add('username')
                ->add('usernameCanonical')
                ->add('email')
                ->add('emailCanonical')
                ->add('enabled')
                ->add('salt')
                ->add('password')
                ->add('lastLogin')
                ->add('confirmationToken')
                ->add('passwordRequestedAt')
                ->add('roles')
                ->add('lastActivityAt');
            }
        $builder
            ->add('telnr')
            ->add('mobilenr')
            ->add('first_name')
            ->add('insertion')
            ->add('last_name')
            ->add('adres')
            ->add('zip')
            ->add('city')
            ->add('country');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
