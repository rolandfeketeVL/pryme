<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditClientFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('roles')
            ->add('password')
            ->add('firstName')
            ->add('lastName')
            ->add('phone')
            ->add('gender')
            ->add('birthdate')
            ->add('street')
            ->add('state')
            ->add('city')
            ->add('country')
            ->add('zip')
            ->add('totalBookings')
            ->add('lastBooking')
            ->add('membershipExpiryDate')
            ->add('creditsRemaining')
            ->add('emailConsent')
            ->add('smsConsent')
            ->add('membership')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
